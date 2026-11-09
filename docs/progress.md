# Project Progress

> Loaded into every session via CLAUDE.md — keep it short and current.
> Edit module sections in place. Session log: last 10 entries only (git has the rest).
> Cross-module connections live in CLAUDE.md → "Dependencies map"; not repeated here.

---

## Current status
- **Branch:** `main` (2026-11-09).
- **Last done:** "تم التسجيل عن طريق" names list (SettingModule) + admin-only report filter (9f1f921 … a40f3aa); permissions `show_reg_by_in_copy` (d4a2edd) and `show_company_in_reports` (6a92c17); old→new name in `UpdateRegBy` log (ed85d66); student page registrations use the course page's buttons/modals via shared partials (5a2af2d); "طرق الدفع" payment methods list (SettingModule) used by the payments modal, saved as `course_reg_payments.payment_method_id` (3b7db54). All committed except this docs checkpoint. All local migrations ran.
- **Working on:** nothing in progress.
- **Before deploying:** migrate **SettingModule first**: `php artisan module:migrate SettingModule` then `php artisan module:migrate` — plain `module:migrate` runs modules alphabetically, so CourseModule's data migrations (`000003` reg-by fill, `000006` payment-method fill) would fail because `reg_by_employees` / `payment_methods` don't exist yet. Check `SELECT pay_method, COUNT(*) FROM course_reg_payments GROUP BY 1` (rows whose value isn't one of the 7 enum values stay without `payment_method_id` and show the old text). Also run on production `SELECT TRIM(registered_by), COUNT(*) FROM course_regs GROUP BY 1` and add any new spelling variants to the map in `2026_11_09_000003_fill_reg_by_employee_id_from_registered_by_text` before `php artisan module:migrate`; also enable `SettingModule` (`modules_statuses.json`) and `php artisan optimize:clear`. Create the new permissions: `php artisan tinker --execute="foreach(['show_reg_by_in_copy','show_company_in_reports'] as \$n) Spatie\\Permission\\Models\\Permission::firstOrCreate(['name'=>\$n,'guard_name'=>'user'])"` (the seeder isn't re-runnable), confirm their ids are 6 and 7, then `php artisan permission:cache-reset`.
- **Next up (feature, ?):** dedicated per-employee summary report; fix all-courses export; use the "طرق الدفع" list in unknown payments too (still fixed enum); payment-method filter/column in reports (?).
- **Next up:** owner to confirm the "(?)" items in CLAUDE.md / this file and the README placeholders (name, planned modules, language), then pick work. Candidates: items under "Known issues", expense/income tracking from README (?).
- **Known issues:**
  - `receiptAction` (admin + user Course controllers) calls `$this->courseRegReceipteService`, which is never injected, and there is no `course_reg_receipts` migration → receipt upload is broken/unused (?)
  - `sendStudentsMail` routes point to `sendMailAjax`, which doesn't exist in either Student controller
  - Students: migration column is `note`, but model/service/forms use `notes` → notes probably not saved unless the DB was altered by hand (?)
  - `PermissionSeederTableSeeder` uses `Permission::create` for older permissions → re-running it fails on duplicates; only `can_change_regby` uses `firstOrCreate`
  - `UserService` assigns permissions with `permissions()->sync()` — bypasses spatie cache reset (?)
  - `Course::scopeFilter` interpolates `srch` directly into `whereRaw` → SQL injection risk (CourseReg uses bindings correctly)
  - `GET` routes perform deletes (`/delete/{id}`, `/deleteReg/{id}`) — no CSRF protection
  - All-courses report export (`ReportAllCourses?export=yes`) → 500: `CourseExport` renders `admin.exports.courses_export`, which doesn't exist (`course_export.blade.php` is a registrations table)
  - Opening an admin URL without an admin session → 500 "Route [login] not defined" (auth redirect has no `login` route); affects all admin routes
  - `layoutmodule::users.login` is extended somewhere but that view doesn't exist (?)
  - Git tracks both `Database/Migrations` and `Database/migrations` for Course/Location/Student (case-only duplicates from 80cfb2b; only lowercase is used). Remove the uppercase copies from the index when convenient (`git rm -r --cached Modules/<X>Module/Database/Migrations`, check on a case-sensitive checkout)
  - User create/edit permission checkboxes use hard-coded permission ids (`value="1"`…`"7"`) → wrong permission assigned if production ids differ (check `SELECT id,name FROM permissions` before deploy)
  - Admin/User controllers duplicated — logic drifts between portals
  - No real tests

---

## Modules

### AdminModule
- **Last updated:** 2026-10-17 (memory setup)
- **Files:** `Modules/AdminModule/app/Http/Controllers/{AdminModuleController,Auth/AdminAuthController}.php`, `Models/Admin.php`, `Services/AdminService.php`
- **How it works:** login/logout/change password on `admin` guard; dashboard. Admins see all branches and skip permission checks.
- **Pending:** no admin CRUD routes despite `admin/{index,create,edit,show}` views existing (?)

### UserModule (branch staff)
- **Last updated:** 2026-10-17
- **Files:** `Controllers/Admin/UserAdminModuleController.php` (admin manages users), `Controllers/Auth/UserAuthController.php`, `Services/UserService.php`, `Models/User.php`
- **How it works:** admin creates users with a `branch_id` and a set of permissions; users log in at `/` or `/user/login` on `user` guard. Login/logout logged.
- **Decisions:** permissions per user (no roles in use) — roles seeder is empty.
- **Pending:** `user.dashboard` route commented out; `user/*` views (index/create/show) look unused (?)

### BranchModule
- **Last updated:** 2026-10-17
- **Files:** `Controllers/Admin/BranchAdminController.php`, `Models/Branch.php`, `Services/BranchService.php`
- **How it works:** admin-only CRUD (`admin/branchs`). `branch_id` scopes users, students, courses.
- **Pending:** `Branch::courses()` relation is an empty stub.

### StudentModule
- **Last updated:** 2026-11-09
- **Files:** `Controllers/{Admin/StudentAdminController,User/StudentUserController}.php`, `Services/StudentService.php`, `Repository/StudentRepository.php`, `Models/Student.php`, views `admin/{index,create,edit,show,student_export}`
- **How it works:** CRUD with soft delete → archive list, restore, permanent delete. User portal locks to own branch. Student page lists registrations and lets staff assign the student to a course. Each registration row has the same buttons and modals as the course page (التفاصيل / الدفعات / تغيير حالة الدفع / حذف + "استعراض الدورة") via `coursemodule::admin.partials.*` (2026-11-09). Fields include `academic_qualification` (added 2026-03) and notes.
  - "تم التسجيل عن طريق" on the student page: registration modal has the same change button + dropdown + AJAX as the course page (`{portal}.updateRegBy`); the assign-to-course form uses a required dropdown `reg_by_employee_id` (validated in `assignStudentToCourse` via `CourseRegService::findRegByEmployee`). List comes from `RegByEmployeeService::findAllActive` in `show()`. Both dropdowns use Select2 RTL.
- **Decisions:** delete restricted to admin / `can_delete` permission.
- **Pending:** `note`/`notes` mismatch; send-mail feature missing (see Known issues).

### CourseModule (courses, registrations, payments)
- **Last updated:** 2026-11-09
- **Files:** `Controllers/Admin/{CourseAdminController,UnknownPaymentAdminController}.php` + `User/` twins; `Services/{CourseService,CourseRegService,CourseRegPaymentService,CourseRegStatusService,UnknownPaymentService}.php`; models `Course, CourseReg, CourseRegPayment, CourseRegStatus, CourseRegReceipt, UnknownPayment`; views `admin/{index,show,registers_list,receipt_pdf}`, `admin/unknown_payment/*`; shared registration partials `admin/partials/{reg_actions,reg_modals,reg_modals_js}` (row buttons, details/payments/status modals for one `$reg` + their JS incl. نسخ البيانات; need `$employees` + `$paymentMethods`; rows need `id="reg{id}"` with `.paid_status_id` / `.paid_exam_id`) — used by the course page and the student page; change them once for both
- **How it works:**
  - `Course`: name, group no., org no., dates (stored as strings), price, exam fees, branch.
  - `CourseReg` (student ↔ course): `main_price` / `student_price` / `price` (discount = `student_price − price`), exam fees, status (`course_reg_statuses`, with color), flags `is_course_paid`, `is_exam_paid`, `is_recive_cert`, `is_leave`, `is_free`; registered-by (below).
  - Payments (`course_reg_payments`): type (course instalment / exam / re-exam fees), `paid_at`, method `payment_method_id` → `payment_methods` list "طرق الدفع" (SettingModule, 2026-11-09). Payments modal dropdown = active methods (`$paymentMethods`, passed by Course + Student `show()` in both portals via `CourseRegPaymentService::getPaymentMethods` / `PaymentMethodService::findAllActive`); `payAction` requires an active method (`CourseRegPaymentService::findPaymentMethod`) and writes only `payment_method_id` (old enum `pay_method` left NULL — it can't hold new names). Display uses `CourseRegPayment::payment_method_name` (list name incl. soft-deleted, else old `pay_method`); `paymentMethod` is eager-loaded via `$with`. Assigning an unknown payment sets `payment_method_id` by matching name (`PaymentMethodService::findOneByName`). Paid flags recalculated in `CourseRegPaymentService::takePayAction`.
  - Unknown payments: transfers from unidentified payers, later assigned to a student's registration.
  - Per-student price / discount / exam-price overrides; receipt PDF generation; certificate delivered toggle.
  - "Registered by": `course_regs.reg_by_employee_id` → `reg_by_employees` (SettingModule, added 2026-11-09). Course page dropdown lists active names; saved by AJAX through `{portal}.updateRegBy`: controller → `CourseRegService::findRegByEmployee` → `RegByEmployeeService::findActiveOne` → repository; then `CourseRegService::updateRegBy`. Admin or users with `can_change_regby` can change it. Log description includes old and new name (`... - من <old> الي : <new>`; old empty → `----`). `CourseReg::registered_by_name` returns the list name (incl. soft-deleted), or the old text in `registered_by` for older rows; used everywhere it's displayed. Dropdown is Select2 RTL (`initRegBySelect()` in the view, initialised on "تغير" click with `dropdownParent` = the reg modal).
  - Filters: `CourseReg::scopeFilter` (eager-loads `regByEmployee`; `regby` key) and `Course::scopeFilter` (`regby` → `whereHas courses_regs`).
  - "نسخ البيانات" (copy registration info, course page): adds "تم التسجيل عن طريق : <name>" (read from the modal's `.regByName`) only for admins or users with `show_reg_by_in_copy` (`showRegByInCopy` JS const).
  - Course page Excel (`?export=yes`) → `ReportModule\Exports\CourseRegExport` (fixed 2026-11-09; was 500).
- **Decisions:**
  - Old `registered_by` text column kept; existing values mapped to `reg_by_employee_id` by a data migration (variant → name map inside it). New edits write only `reg_by_employee_id`.
  - Names list is global (not per branch), managed by admin only.
  - Hijri dates removed; `paid_at` is Gregorian — because of commits f3fd3c6 / 270ed05.
  - `pay_type` stored in Arabic. Old `pay_method` enum column kept for legacy rows; mapped to `payment_method_id` by data migration `2026_11_09_000006_fill_payment_method_id_from_pay_method` (7 enum values → 7 list entries; 6,559 rows locally, 0 unmapped; reversible).
- **Pending:** receipt upload broken (Known issues); `coupon_id`, `need_work_agree` columns not clearly used (?); unknown payments (`unknown_payments.pay_method`) still use the fixed 7-value enum — new list methods can't be chosen there (?)

### ReportModule
- **Last updated:** 2026-11-09
- **Files:** `Controllers/{Admin/ReportAdminController,User/ReportUserController}.php`, `Exports/{CourseExport,CourseRegExport,LogExport}.php`, views `admin/*.blade.php`
- **How it works:** reports on CourseReg — not paid, instalments, exam not paid, fully paid, cert received / not received, by company, all students, all courses, students of one course, dropouts (leave), and users' activity log by date range. Paginated; Excel export. User side scoped to own branch and behind `show_reports`.
- **Student Excel exports** all render `exports/course_reg_export.blade.php` (8 student reports, per-course students, course page). Column "قطاع العمل" (`students.company`) shown only for admins or users with `show_company_in_reports` (`$showCompany` at top of the view).
- **Filter "تم التسجيل عن طريق"** (2026-11-09): on the 8 student reports (all, not paid, instalments, exam not paid, paid, cert received / not, leave) — **admin only** (views wrap it in `Auth::guard('admin')->check()`; `ReportUserController` strips `regby` from the query). Query key `regby` = `reg_by_employees.id` or `none` (not set) → `CourseReg::scopeFilter`. Options from `RegByEmployeeService::findAllForFilter` (non-deleted; inactive labelled "(غير مفعل)"). JS in `public/admin-assets/js/custom.js` (`.filter-item-regby`, `#fltr_regby_val`) → also carried to the Excel export and pagination. All-courses report: same filter via `Course::scopeFilter` (`whereHas courses_regs`); "الطلاب" shows `employee / total`; per-course "تقرير الطلاب المسجلين" Excel link carries `regby`.
- **Pending:** README asks for colour-coding per report type — not checked (?); all-courses export broken (Known issues)

### LogModule
- **Last updated:** 2026-10-17
- **Files:** `Services/LogService.php`, `Models/Log.php`, `Repository/LogRepository.php`
- **How it works:** `recordLog(action, description, url)` writes a polymorphic row for the current admin/user. Filter by user, branch, date range. Viewed through Reports → users log.
- **Pending:** module's own `logmodule` route is scaffold only.

### PermissionModule
- **Last updated:** 2026-10-17
- **Files:** `Database/Seeders/PermissionSeederTableSeeder.php`, `app/Http/Models/_*.php`
- **How it works:** seeds `user`-guard permissions: `show_reports`, `can_delete`, `can_edit`, `view_only`, `can_change_regby`, `show_reg_by_in_copy`, `show_company_in_reports` (2026-11-09; last three via `firstOrCreate`). User create/edit forms list them as **hard-coded checkboxes whose `value` is the permission id** (1–7) — ids must match the DB.
- **Pending:** seeder not idempotent; no UI for roles.

### SettingModule (إعدادات النظام)
- **Last updated:** 2026-11-09 (new)
- **Files:** `Controllers/Admin/{SettingAdminController,RegByEmployeeAdminController,PaymentMethodAdminController}.php`, `Models/{RegByEmployee,PaymentMethod}.php`, `Services/{RegByEmployeeService,PaymentMethodService}.php`, `Repository/{RegByEmployeeRepository,PaymentMethodRepository}.php`, migrations `2026_11_09_000001_create_reg_by_employees_table`, `2026_11_09_000004_create_payment_methods_table`, views `admin/index`, `admin/reg_by_employees/{index,edit}`, `admin/payment_methods/{index,edit}`; nav item "إعدادات النظام" (not a link — only opens the sub-menu) with hover sub-menu in `layoutmodule::admin.nav` (CSS `.has-submenu` / `.nav-submenu` in `public/admin-assets/css-rtl/custom-rtl.css`) — add new settings pages as `<li>` in that sub-menu
- **How it works:** admin-only (`admin/settings`, `auth:admin`). Settings landing page → "قائمة تم التسجيل عن طريق": add (inline), edit name, activate/deactivate (`is_active`), delete (soft delete, POST). List shows registration count per name. Create/update/delete are logged. Only active names appear in the course dropdown.
  - "طرق الدفع" (`admin/settings/payment_methods`, routes `admin.settings.payment_methods.*`): same pages/behaviour as the names list (add, edit, activate/deactivate, soft delete, logged); list shows payments count. Active methods appear in the payments modal (course + student pages).
- **Decisions:** soft delete so registrations/reports keep the name; unique name among non-deleted rows.
- **Service methods (PaymentMethodService):** `findAll` (+ payments count), `findAllActive`, `findActiveOne`, `findOne`, `findOneByName` (unknown-payment mapping), `deleteOne`.
- **Service methods (RegByEmployeeService):** `findAll` (admin list + regs count), `findAllActive` (dropdowns), `findActiveOne` (validation), `findAllForFilter` (report filter: non-deleted incl. inactive).
- **Pending:** dedicated per-employee summary report (?); names list is global — add `branch_id` if branches need their own lists.

### LocationModule
- **Last updated:** 2026-10-17
- **Files:** `Models/{Country,City,Region}.php`, services/repos
- **How it works:** reference data; cities feed the student form. Resource route is scaffold only.

### LayoutModule
- **Last updated:** 2026-11-09 (nav sub-menu support)
- **Files:** `resources/views/admin/{main,header,nav,footer,flash,modals,custom_pagination,login}.blade.php`, `user/nav.blade.php`
- **How it works:** single RTL master layout; header/nav switch by active guard. Nav items can have a hover/focus sub-menu: `<li class="has-submenu">` + `<ul class="nav-submenu">` (CSS in `custom-rtl.css`). "إعدادات النظام" sub-menu: قائمة تم التسجيل عن طريق, طرق الدفع.

### Expenses / income tracking — planned (?)
- **Status:** Not started. Listed in README overview ("income tracking, expense management"); no code exists. Confirm it's still planned.

---

## Session log

### 2026-11-09 — "طرق الدفع" payment methods list
- **Changed:** SettingModule: `payment_methods` table + model/repo/service/admin controller/views (`admin/settings/payment_methods`), settings landing row, nav sub-menu item. CourseModule: migrations `000005` (add `course_reg_payments.payment_method_id`) and `000006` (create the 7 old enum values as methods, fill the id); payments modal (`partials/reg_modals`) lists active methods and posts `payment_method_id`; Course `payAction` (both portals) validates an active method; `CourseRegPaymentService` saves the id; `CourseRegPayment::payment_method_name` for display; unknown-payment assign sets the id by name. Student `show()` (both portals) passes `$paymentMethods`.
- **Why:** admin manages payment methods instead of a fixed enum; store the id for reports.
- **Affects:** SettingModule, CourseModule, StudentModule, LayoutModule (nav). Deploy: migrate SettingModule first.
- **Commit:** 3b7db54

### 2026-11-09 — Student page: registration buttons/modals like the course page
- **Changed:** extracted the course page's registration buttons, 3 modals and their JS into `CourseModule/resources/views/admin/partials/{reg_actions,reg_modals,reg_modals_js}.blade.php`; course page includes them (rendered HTML unchanged); student page now includes them too (old simple details/payments modals and their JS removed).
- **Why:** show التفاصيل / الدفعات / تغيير حالة الدفع on the student page the same as on the course page, without duplicating ~1,100 lines.
- **Affects:** CourseModule + StudentModule show views (both portals). Backend unchanged (actions use `back()`).
- **Commit:** 5a2af2d

### 2026-11-09 — "تم التسجيل عن طريق" names list (SettingModule) + report filter
- **Changed:**
  - New `Modules/SettingModule`: `reg_by_employees` CRUD (soft delete, `is_active`), admin nav "إعدادات النظام" (non-clickable, hover sub-menu; CSS in `custom-rtl.css`).
  - Migrations (lowercase `Database/migrations`): `..._000001_create_reg_by_employees_table` (SettingModule), `..._000002_add_reg_by_employee_id_to_course_regs_table`, `..._000003_fill_reg_by_employee_id_from_registered_by_text` (CourseModule) (data: old text → 9 names, variants merged; 3,618 rows locally; "-", "المعهد", "حوالة", "570", empty left NULL; reversible).
  - Course + student pages: Select2 RTL dropdown + AJAX via `{portal}.updateRegBy`; assign-to-course form requires a list name.
  - Reports: admin-only `regby` filter on 8 student reports + all-courses report, carried into Excel exports; user controller strips `regby`.
  - Fixed course page Excel export (missing import / wrong class).
  - CLAUDE.md: Controller → Service → Repository rule; Select2 note; deps map.
- **Why:** store the employee who registered the student as an id (for reports) instead of free text.
- **Affects:** SettingModule, CourseModule, StudentModule, ReportModule, LayoutModule, `custom.js`, `custom-rtl.css`, `modules_statuses.json`
- **Commit:** 9f1f921, 80cfb2b (migrations folder case), ead253a, a40f3aa
- **Later same day:** "نسخ البيانات" includes "تم التسجيل عن طريق" for admins / users with new permission `show_reg_by_in_copy` (seeder + user form checkboxes) — d4a2edd. Then: "قطاع العمل" in student Excel exports only for admins / users with new permission `show_company_in_reports` (id 7) — 6a92c17; `UpdateRegBy` log shows old → new name — ed85d66

### 2026-10-17 — Initial project memory setup
- **Changed:** `CLAUDE.md`, `docs/progress.md` filled in from codebase exploration
- **Why:** give each session project context
- **Affects:** none (docs only)
- **Commit:** f68cd06
