# Project Progress

> Loaded into every session via CLAUDE.md — keep it short and current.
> Edit module sections in place. Session log: last 10 entries only (git has the rest).
> Cross-module connections live in CLAUDE.md → "Dependencies map"; not repeated here.

---

## Current status
- **Branch:** `main`, working tree clean apart from these memory files (2026-10-17).
- **Working on:** permissions for the user portal — latest commits (2026-10-08) added `can_change_regby` and restricted "registered by" (التسجيل عن طريق) edits. Nothing in progress in the working tree.
- **Next up:** owner to confirm the "(?)" items in CLAUDE.md / this file and the README placeholders (name, planned modules, language), then pick work. Candidates: items under "Known issues", expense/income tracking from README (?).
- **Known issues:**
  - `receiptAction` (admin + user Course controllers) calls `$this->courseRegReceipteService`, which is never injected, and there is no `course_reg_receipts` migration → receipt upload is broken/unused (?)
  - `sendStudentsMail` routes point to `sendMailAjax`, which doesn't exist in either Student controller
  - Students: migration column is `note`, but model/service/forms use `notes` → notes probably not saved unless the DB was altered by hand (?)
  - `PermissionSeederTableSeeder` uses `Permission::create` for older permissions → re-running it fails on duplicates; only `can_change_regby` uses `firstOrCreate`
  - `UserService` assigns permissions with `permissions()->sync()` — bypasses spatie cache reset (?)
  - `Course::scopeFilter` interpolates `srch` directly into `whereRaw` → SQL injection risk (CourseReg uses bindings correctly)
  - `GET` routes perform deletes (`/delete/{id}`, `/deleteReg/{id}`) — no CSRF protection
  - `layoutmodule::users.login` is extended somewhere but that view doesn't exist (?)
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
- **Last updated:** 2026-10-17
- **Files:** `Controllers/{Admin/StudentAdminController,User/StudentUserController}.php`, `Services/StudentService.php`, `Repository/StudentRepository.php`, `Models/Student.php`, views `admin/{index,create,edit,show,student_export}`
- **How it works:** CRUD with soft delete → archive list, restore, permanent delete. User portal locks to own branch. Student page lists registrations/payments and lets staff assign the student to a course. Fields include `academic_qualification` (added 2026-03) and notes.
- **Decisions:** delete restricted to admin / `can_delete` permission.
- **Pending:** `note`/`notes` mismatch; send-mail feature missing (see Known issues).

### CourseModule (courses, registrations, payments)
- **Last updated:** 2026-10-17
- **Files:** `Controllers/Admin/{CourseAdminController,UnknownPaymentAdminController}.php` + `User/` twins; `Services/{CourseService,CourseRegService,CourseRegPaymentService,CourseRegStatusService,UnknownPaymentService}.php`; models `Course, CourseReg, CourseRegPayment, CourseRegStatus, CourseRegReceipt, UnknownPayment`; views `admin/{index,show,registers_list,receipt_pdf}`, `admin/unknown_payment/*`
- **How it works:**
  - `Course`: name, group no., org no., dates (stored as strings), price, exam fees, branch.
  - `CourseReg` (student ↔ course): `main_price` / `student_price` / `price` (discount = `student_price − price`), exam fees, status (`course_reg_statuses`, with color), flags `is_course_paid`, `is_exam_paid`, `is_recive_cert`, `is_leave`, `is_free`, `registered_by`.
  - Payments (`course_reg_payments`): type (course instalment / exam / re-exam fees), Arabic `pay_method` enum, `paid_at`; paid flags recalculated in `CourseRegService` (?).
  - Unknown payments: transfers from unidentified payers, later assigned to a student's registration.
  - Per-student price / discount / exam-price overrides; receipt PDF generation; certificate delivered toggle.
  - `registered_by` editable by admin or users with `can_change_regby`.
- **Decisions:**
  - Hijri dates removed; `paid_at` is Gregorian — because of commits f3fd3c6 / 270ed05.
  - Payment enums stored in Arabic.
- **Pending:** receipt upload broken (Known issues); `coupon_id`, `need_work_agree` columns not clearly used (?)

### ReportModule
- **Last updated:** 2026-10-17
- **Files:** `Controllers/{Admin/ReportAdminController,User/ReportUserController}.php`, `Exports/{CourseExport,CourseRegExport,LogExport}.php`, views `admin/*.blade.php`
- **How it works:** reports on CourseReg — not paid, instalments, exam not paid, fully paid, cert received / not received, by company, all students, all courses, students of one course, dropouts (leave), and users' activity log by date range. Paginated; Excel export. User side scoped to own branch and behind `show_reports`.
- **Pending:** README asks for colour-coding per report type — not checked (?)

### LogModule
- **Last updated:** 2026-10-17
- **Files:** `Services/LogService.php`, `Models/Log.php`, `Repository/LogRepository.php`
- **How it works:** `recordLog(action, description, url)` writes a polymorphic row for the current admin/user. Filter by user, branch, date range. Viewed through Reports → users log.
- **Pending:** module's own `logmodule` route is scaffold only.

### PermissionModule
- **Last updated:** 2026-10-17
- **Files:** `Database/Seeders/PermissionSeederTableSeeder.php`, `app/Http/Models/_*.php`
- **How it works:** seeds `user`-guard permissions: `show_reports`, `can_delete`, `can_edit`, `view_only`, `can_change_regby`.
- **Pending:** seeder not idempotent; no UI for roles.

### LocationModule
- **Last updated:** 2026-10-17
- **Files:** `Models/{Country,City,Region}.php`, services/repos
- **How it works:** reference data; cities feed the student form. Resource route is scaffold only.

### LayoutModule
- **Last updated:** 2026-10-17
- **Files:** `resources/views/admin/{main,header,nav,footer,flash,modals,custom_pagination,login}.blade.php`, `user/nav.blade.php`
- **How it works:** single RTL master layout; header/nav switch by active guard.

### Expenses / income tracking — planned (?)
- **Status:** Not started. Listed in README overview ("income tracking, expense management"); no code exists. Confirm it's still planned.

---

## Session log

### 2026-10-17 — Initial project memory setup
- **Changed:** `CLAUDE.md`, `docs/progress.md` filled in from codebase exploration
- **Why:** give each session project context
- **Affects:** none (docs only)
- **Commit:** (pending) `docs: add project memory (CLAUDE.md, progress.md)`
