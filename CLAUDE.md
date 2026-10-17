# Project: Noon-Training Accounting System (Acc_NoonTraining)

@docs/progress.md

Back-office accounting for Noon-Training centre branches: students, course registrations, payments
(incl. unmatched bank transfers), certificates, and reports. Two portals: **admin** (all branches) and
**user** (branch staff, scoped to their own branch, gated by permissions).

## Before you start (every session)
1. `docs/progress.md` is loaded above — treat it as the latest state, decisions, and cross-module dependencies.
2. Run `git log --oneline -15` to see recent changes.
3. If the task touches a module listed under "Dependencies map", check the related files before editing.

## When a task or feature is done
When a task is finished, or when I say "update progress" or run /checkpoint, update `docs/progress.md`:
- Edit the relevant module section (files, how it works, dependencies, decisions, pending) — don't just append.
- Add one entry to the session log; keep only the last 10 entries.
- Update "Current status".
Then suggest a commit message.

## Stack
- Framework: Laravel 10 / PHP ^8.1, modular via `nwidart/laravel-modules` v10
- Database: MySQL (?) — `DB_CONNECTION` in .env; raw SQL uses MySQL-style `"%...%"` LIKE strings
- Frontend: Blade + jQuery + Bootstrap RTL admin theme (static files in `public/admin-assets/`). Vite is configured but not used by module views (?)
- Auth: custom session guards `admin` (model `AdminModule\...\Admin`, table `admins`) and `user` (model `UserModule\...\User`, table `users`) in `config/auth.php`
- Permissions: `spatie/laravel-permission` v6, permissions on guard `user` only (admins bypass)
- Key packages: `prettus/l5-repository` (repositories), `maatwebsite/excel` (exports), `niklasravnsborg/laravel-pdf` (receipt PDF), `geniusts/hijri-dates` (no longer used — Hijri removed), `laravel/sanctum` (unused (?))

## Commands
- Dev server: `php artisan serve` (or local Apache — project has `.htaccess` / `server.php`)
- Assets: none needed for module views; `npm run dev` only for `resources/` (unused)
- Migrate: `php artisan module:migrate` (module migrations) + `php artisan migrate` (spatie tables in `database/migrations`)
- Seed: `php artisan module:seed PermissionModule` — seeds `user`-guard permissions
- Tests: `php artisan test` (only Laravel example tests exist)
- Clear caches: `php artisan optimize:clear` (+ `php artisan permission:cache-reset` after permission changes)

## Project structure
- `Modules/<Name>Module/` — all features. Inside each module:
  - `app/Http/Controllers/Admin/*AdminController.php` and `User/*UserController.php` — one controller per portal
  - `app/Http/Models/` — Eloquent models (note: models live under `Http/Models`, not `app/Models`)
  - `Services/` — business logic; `Repository/` — prettus `BaseRepository` subclasses
  - `Database/migrations` or `Database/Migrations` (case is inconsistent), `Database/Seeders/`
  - `resources/views/admin/` — views, shared by **both** portals; `routes/web.php`
- `Modules/LayoutModule/resources/views/admin/` — master layout (`main`), header, nav, flash, modals, pagination; `user/nav.blade.php` for the user portal
- `Modules/ReportModule/Exports/` — Excel export classes (render Blade views under `admin/exports/`)
- `app/Helpers/` — `UploaderHelper`, `ApiResponseHelper`, `FcmHelper` (FCM likely unused (?))
- `database/migrations/` — only the spatie permission tables
- `modules_statuses.json` — enabled modules
- `public/admin-assets/`, `public/assets/` — theme CSS/JS. `public/hoe_cats.php`, `public/mkg_request.php` look like unrelated stray files (?)

## Conventions
- Route names: `{portal}.{module}.{action}` e.g. `admin.courses.show`, `user.students.edit`. Some exceptions: `admin.ChangePriceForOneStudent`, `admin.updateRegBy`, `admin.Receipt.gen_pdf`, `admin.users.list` vs `admin.user.create`
- URLs: `admin/<module>/...` and `user/<module>/...`; update/delete use `POST /update` (id in body) and `GET /delete/{id}`
- Controllers reference by string `'Admin\XController@method'` (module RouteServiceProvider namespace)
- Always use named routes — never hardcoded URLs
- Validation: inline `Validator::make(...)` in controllers, Arabic error messages; no Form Requests. (proposed) keep inline for consistency
- Business logic: Services → Repositories; but controllers also query models / do branch checks directly
- Admin + User controllers are near-duplicates: **any change to one usually must be mirrored in the other**
- Branch scoping (user portal): force `branch_id` / `branch` filter from `Auth::guard('user')->user()->branch_id` and compare ownership in show/edit
- Permission checks: `$user->can('can_edit')` in controllers, `@can` / `@cannot('view_only')` in Blade, `permission:show_reports` middleware on user reports
- Audit: call `LogService::recordLog($action, $description, $url)` on create/update/delete actions
- Filtering: model `scopeFilter($query, $request)` with short query keys (`srch`, `srt`, `branch`, `fltr_sts`, `fltr_crt`, `fltr_leave`)
- Flash: `back()->with('success', 'تمت العمليه بنجاح.')` / `->withErrors(...)`
- Language / direction: Arabic UI, RTL CSS (`css-rtl/`), though `<html lang="en" data-textdirection="ltr">` in layout. Arabic enum values stored in DB (`pay_method`, `pay_type`)
- Naming: snake_case columns with abbreviations (`id_nu`, `group_nu`, `is_recive_cert`); methods mostly camelCase, some PascalCase (`ReportAllStudents`, `UpdateRegBy`); migrations edited in place historically — don't continue that

## Dependencies map (what affects what)
- **UserModule** ↔ Branch (`users.branch_id`), Permission (spatie roles/perms on `user` guard), Log (login/logout logged)
- **AdminModule** ↔ Log; admins manage Users, Branches, everything
- **BranchModule** ↔ scoping for Users, Students, Courses; filters in Reports and Logs
- **StudentModule** ↔ Branch, Location (`city_id`), Course (`CourseReg`, payments shown on student page), Log
- **CourseModule** (courses, registrations, payments, statuses, unknown payments, receipt PDF) ↔ Student, Branch, Log, Permission (`can_edit`, `can_delete`, `can_change_regby`); `CourseReg` fields drive every report
- **ReportModule** ↔ reads Course/CourseReg/Student/Log; Excel exports in `Exports/`; user side behind `show_reports`
- **LogModule** ↔ polymorphic `userable` (Admin | User); written by Course, Student, Auth controllers; viewed in Reports → users log
- **PermissionModule** ↔ only seeders + model wrappers; permissions assigned per user in UserModule admin create/edit (`UserService` → `permissions()->sync()`)
- **LocationModule** ↔ cities list for Student forms; no UI of its own
- **LayoutModule** ↔ every view (`layoutmodule::admin.main`); nav changes per guard
- **Expenses / income tracking** (planned (?), mentioned in README) ↔ Branch, Reports

## Rules
- Before renaming anything shared (routes, components, config keys), search the whole project for references and update them all.
- Never edit migrations that already ran — create a new migration.
- Ask before deleting files or changing shared layouts.
- Keep changes minimal and scoped to the task.
