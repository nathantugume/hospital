# MediTrack reference UI in Laravel

## Design source

The reference is `/home/nathan/Downloads/meditrack-hms.zip` (209 HTML pages). Its SHA-256 is `2488815b70525aa0422ba7e91a2c74011fee1b4bdde9866214694cd7e80d2a3c`. The archive's `public/style.css` remains the project's unchanged template stylesheet. Original reference views remain in `resources/views/legacy/`.

Use the reference markup and SVGs when adding screens. Keep rendering in Blade and persistence, validation, authorization, and reporting in Laravel. Do not load the prototype's localStorage store, demo authentication, global form interception, or sample-data scripts into native views.

## Shared presentation

- `layouts/app.blade.php`, `partials/header.blade.php`, and `partials/sidebar.blade.php` retain the reference header, 256px sidebar, logo, menu groups, and responsive spacing. The desktop breakpoint is 1280px, matching the template.
- `public/style.css` owns the template's design. `public/blade.css` supports native forms and small integration details; its old dark-blue shell and global table typography no longer override the reference.
- `public/js/blade-ui.js` handles UI state only: light/dark theme, navigation, keyboard focus, dashboard tabs, password visibility, and exports of rendered data. Only theme and sidebar preferences use localStorage.
- Shared guest layout and login use the reference centered logo and account card. Login posts to Laravel with CSRF protection and no prefilled demo password.
- Patient and doctor menus use reference avatars and three-dot actions. Links continue to use named routes and policy checks. Patients use the reference columns; the doctor column comes from the latest appointment, not a fabricated assignment.
- The shared pagination partial renders database pagination, including the current page and record count. Table exports explicitly export the visible page.

## Dashboard data

`DashboardController` validates the date range and loads monthly revenue and appointment counts. `DashboardAnalytics` supplies the original analytics panel structure from existing records:

| Panel | Laravel data |
|---|---|
| Total Revenue | Paid invoices within the selected payment dates |
| Appointments | Appointments in the selected date range |
| Patients / Staff | Current active records |
| Overview | Monthly paid revenue, with a readable data table including visit counts |
| Patient Demographics | Current registered patients grouped by age and gender |
| Appointment Types | Appointment type counts within the selected dates |
| Revenue Sources | Collected revenue by payment method; departmental payment allocation is not present in the invoice schema |
| Patient Satisfaction | Recorded feedback averages by category |
| Staff Performance | Recorded review averages by staff member |
| Notifications | Only the authenticated user's notifications |

Empty panels stay empty when there are no records. Sample people, percentages, payments, and chart series from the archive are not application data. Selected start and end dates are inclusive, including SQLite values stored with a time component. Reports are limited to one year per request.

A patient without a linked patient record receives an empty personal dashboard rather than falling back to general hospital data.

## Existing native screens and remaining modules

Current native routes include the role dashboards, patient and doctor CRUD, appointments, care team, laboratory, test requests, pharmacy, stock alerts, invoices, financial reports, prescriptions, settings, and authentication. All use the shared reference presentation.

The archive contains more screens than the implemented backend. `LegacyPageController` still returns the existing coming-soon view for those modules. The restored menu does not imply that all 209 modules are functional. The language control currently indicates English; automatic translation is not wired into native screens. Dashboard reports expose the existing financial report rather than claiming that unimplemented reports can be generated.

## Verification

Verification uses an isolated SQLite database seeded with demo records. The existing `.env`, application key, and project database are preserved. No deployment is part of this UI change.

- Native Blade compilation: 45 views.
- Browser comparisons: 1440px desktop and 390px phone, including light/dark mode, sidebar opening and closing, keyboard focus, date filtering, patient status filtering, and tabbed patient forms.
- Tests: `tests/Feature/Web/ReferenceUiTest.php` covers real chart values, date boundaries and validation, notification isolation, patient navigation, and native login form structure. Existing web and CRUD tests remain applicable.
- Full regression run on 2026-09-09: 62 tests completed with no failures, 329 assertions, exit code 0 (131.32 seconds). The existing PHP 8.5 PDO deprecation notices were reported.
- Local screenshots are saved under `/home/nathan/.cache/hospital-ui-verification/2026-09-09/` using isolated demo records. These are visual checks, not a claim of automated pixel equality across all 209 archive pages.

Run the complete PHPUnit suite before release; CI also validates PHP syntax and Laravel caches. PHP 8.5 currently emits deprecation notices from the existing MySQL PDO constant configuration; CI targets PHP 8.3.
