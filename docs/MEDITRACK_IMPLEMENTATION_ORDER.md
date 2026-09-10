# MediTrack HMS Implementation Order

## Purpose

This roadmap turns the current MediTrack codebase into a complete Laravel and Blade hospital management system while preserving the verified `meditrack-hms` reference design.

The application currently has a broad database and API foundation, 209 archived reference pages, and a smaller set of native Blade screens. A module is complete only when its visible workflow uses Laravel routes, authorization, validation, database persistence, and the shared Blade UI. Archived HTML and localStorage behavior do not count as implementation.

## Delivery rules for every phase

Apply these rules to every module before marking it complete:

1. Inspect the relevant migration, model, policy, Form Request, API controller, native Blade view, and matching legacy reference page.
2. Add or update named web routes and Web controllers. Use Form Requests for writes and policies for every list and record action.
3. Scope all non-super-admin queries and writes to the authenticated user's `company_id`.
4. Render escaped database values in Blade, preserve CSRF protection, and keep the reference navigation, typography, tables, actions, forms, and responsive behavior.
5. Do not load legacy demo authentication, sample arrays, global form interception, or localStorage persistence into native pages.
6. Cover successful writes, validation failures, denied roles, cross-company denial, and relevant status transitions with targeted tests.
7. Verify the rendered workflow at desktop and phone widths, including empty states, errors, action menus, and saved data after refresh.
8. Replace a legacy `*.html` placeholder with a redirect to the native route only after the native workflow passes its acceptance checks.

## Phase 0 — Security and tenancy foundation

Complete this before adding more write workflows because current web and collection queries are not consistently company-scoped.

### Work

- [x] Introduce reusable company-scoping mechanisms for tenant-owned and patient-owned clinical models.
- [x] Apply company scoping to the active patient, staff, department, appointment, invoice, claim, prescription, laboratory, report, and dashboard workflows.
- [x] Enforce existing policies in the active patient and doctor CRUD workflows and core list screens.
- [x] Scope the core patient, doctor, appointment, invoice, prescription, laboratory, and test-request API collections and writes.
- [x] Assign `company_id` from the authenticated user for patient, staff, appointment, and invoice creation paths.
- [x] Add cross-company list and record-access feature tests for patients, appointments, and doctors.
- [ ] Extend company scoping to medicines, inventory, rooms, and all remaining APIs after their schemas are made tenant-owned.
- [ ] Add cross-company coverage for every create, update, delete, export, report, and dashboard workflow.

### Acceptance gate

- Staff from company A cannot list, view, modify, count, or export company B records.
- Super admins retain explicitly tested cross-company access.
- Patient users can access only their linked patient record.

## Phase 1 — Shared application foundations

Build the shared pieces needed by the remaining screens.

### Work

- Create reusable Blade components for page headings, filters, forms, status badges, empty states, confirmation dialogs, tables, action menus, and pagination.
- Standardize flash messages and validation summaries.
- Add safe server-side CSV exports and print views where the reference design exposes export actions.
- Finish the notification center: list, mark one read, mark all read, and delete.
- Add shared audit metadata to important writes: actor, company, record, action, and timestamp.
- Keep theme and sidebar preferences as the only browser-local state.

### Acceptance gate

- Shared components behave consistently across phone and desktop widths.
- Notifications are isolated to the authenticated user.
- Exported data respects the same authorization and filters as the screen.

## Phase 2 — Appointments and scheduling

Appointments connect patients, doctors, departments, services, reminders, billing, and clinical work. They should be the first complete operational module.

### Work

- [x] Add appointment create, show, edit, reschedule, confirm, cancel, complete, and no-show web workflows.
- [x] Validate appointment duration, department, tenant-owned patient and clinician selections, and overlapping doctor time conflicts.
- [x] Add persisted recurring and date-specific clinician availability slots and enforce configured slots while scheduling.
- [x] Redirect `appointments.html` and `add-appointment.html` to their native Blade routes.
- [x] Build a database-backed monthly appointment calendar.
- [x] Add database-backed day and week calendar views.
- [x] Implement patient appointment requests and staff approval or rejection.
- [x] Add doctor availability management with recurring and date-specific slots.
- [x] Add doctor schedules, leave, and time-off management.
- [x] Redirect `appointment-calendar.html` to the native monthly calendar.
- [x] Redirect `appointment-details.html`, `appointment-reschedule.html`, `appointment-requests.html`, and related schedule pages when their native routes are complete.

### Acceptance gate

- Creating or rescheduling an appointment detects conflicts atomically.
- Patients see only their appointments; doctors see their assigned appointments.
- Status changes persist, are authorized, and appear on dashboards after refresh.

## Phase 3 — Staff, departments, services, and permissions

### Work

- [x] Complete staff CRUD beyond the existing doctor-specific CRUD.
- [x] Implement tenant-scoped departments and services, including active/inactive lifecycle management and appointment-form propagation.
- [x] Implement tenant-scoped ward CRUD and department assignment.
- [x] Implement tenant-scoped service availability management.
- [x] Implement tenant-scoped specialization management and doctor-form propagation.
- [x] Implement staff certification management with issue, expiry, and credential status tracking.
- [x] Implement attendance, timesheets, leave, and performance reviews.
- [x] Build role and permission assignment with an auditable change history.
- [x] Link staff accounts to staff records without creating duplicate users.
- [x] Add company management and subscription administration for super admins.
- [x] Convert the matching staff, department, service, role, company, and subscription reference pages to native Blade screens.

### Acceptance gate

- [x] Role changes immediately affect server-side access.
- [x] Deactivated staff cannot authenticate or receive new assignments.
- [x] Department and service changes propagate to appointment and clinical forms.

## Phase 4 — Laboratory workflow

### Work

- [x] Add tenant-scoped test request creation and requested-test selection.
- [x] Add authorized, atomic sample collection and create pending results for requested tests.
- [x] Add authorized result entry, abnormal flags, and verifier-controlled completion.
- [x] Add private result attachments with authorized downloads and revocable, expiring result sharing.
- [x] Add tenant-owned lab test catalogue and equipment CRUD while preserving read-only shared catalogue records.
- [x] Restrict result verification to authorized laboratory staff or doctors.
- [x] Trigger patient and doctor notifications only after an abnormal result is verified.
- [x] Convert the test request, sample collection, result entry, lab result, lab test management, and equipment reference pages.

### Acceptance gate

- [x] The request lifecycle is enforced: requested → collected → in progress → completed → verified.
- [x] Results cannot be verified without required values and verifier identity.
- [x] Shared result tokens are revocable, limited, and do not expose unrelated patient data.

## Phase 5 — Prescriptions and pharmacy

### Work

- [x] Complete prescription list, detail, edit, renew, discontinue, and patient prescription views.
- [x] Complete atomic prescription dispensing with batch stock control.
- [x] Add medicine, batch, stock transaction, medication administration, and expiry management.
- [x] Make dispensing update batch and medicine stock within a database transaction.
- [x] Prevent negative stock and duplicate dispensing.
- [x] Build medicine templates and low-stock or expiry alerts from database thresholds.
- [x] Convert the pharmacy, medicine, prescription, stock-alert, and related reference pages.

### Acceptance gate

- [x] Prescribing does not reduce stock; dispensing does.
- [x] Dispensing is atomic and records the user, batch, quantity, and patient.
- [x] Out-of-stock and expired batches cannot be dispensed.

## Phase 6 — Billing, receipts, insurance, and payments

### Work

- Add invoice create, detail, edit, cancel, service items, discounts, taxes, and patient responsibility.
- Add payment recording, partial payments, receipts, reversals, and printable/PDF documents.
- Add insurance provider, eligibility verification, pre-authorization, claim submission, communication, rejection, approval, and settlement workflows.
- Implement MTN MoMo, Airtel Money, and M-Pesa behind enforced feature flags.
- Make callbacks idempotent and verify provider signatures or authentication before updating payments.
- Reconcile invoice balance and payment state in database transactions.
- Convert billing, invoice, receipt, payment, claim, insurance verification, and financial report reference pages.

### Acceptance gate

- Invoice balances cannot become negative or be paid twice by repeated callbacks.
- Every payment has an immutable provider or manual reference and audit entry.
- Financial reports reconcile with invoice items and recorded payments for the same period.

## Phase 7 — Inventory and procurement

### Work

- Implement inventory items, suppliers, supplier products, purchase orders, order tracking, transfers, dispatch, receipt, and stock history.
- Use transactions and locking for quantity changes.
- Connect medicine procurement to the shared inventory rules where applicable.
- Add reorder alerts and inventory reports.
- Convert inventory, supplier, purchase-order, transfer, and stock-report reference pages.

### Acceptance gate

- Each stock change has a source document, actor, date, quantity, and destination.
- Transfers cannot be received twice or move more stock than is available.
- Reports reconcile opening stock, movements, and closing stock.

## Phase 8 — Rooms, wards, surgery, and radiology

### Work

- Implement room and bed management, allotment, transfer, discharge, and occupancy reporting.
- Add operating theatre schedules, surgery teams, rooms, status transitions, and surgical notes.
- Add radiology ordering, scheduling, image metadata, reporting, and attachments.
- Treat the archived PACS viewer as a UI reference; integrate a real DICOM/PACS service before claiming diagnostic image viewing.
- Convert room, allotment, OT, surgery, radiology list, report, schedule, and viewer reference pages.

### Acceptance gate

- A bed, room, clinician, or theatre cannot be double-booked for overlapping periods.
- Clinical reports record authorship, verification, and finalization state.
- Uploaded files use authorized private storage and controlled downloads.

## Phase 9 — Blood bank and ambulance

### Work

- Implement donors, donations, blood units, compatibility checks, issue, return, expiry, and stock reporting.
- Implement ambulance fleet, calls, dispatch, arrival, completion, crew assignment, and location history.
- Enforce emergency-call roles and audit all dispatch status changes.
- Connect GPS and emergency voice providers only after real credentials and webhook validation are available.
- Convert blood bank and ambulance reference pages.

### Acceptance gate

- Expired, quarantined, incompatible, or already-issued blood units cannot be issued.
- Ambulance dispatch has one active assignment per vehicle and preserves its event timeline.

## Phase 10 — Remaining clinical and records modules

Implement these after the shared appointment, inventory, billing, and authorization foundations are stable.

### Work

- Vaccination schedules and administration records.
- Physiotherapy sessions, treatment plans, exercises, schedules, and home-exercise plans.
- Birth and death records, verification, and certificate generation.
- Nutrition and meal schedules.
- Patient feedback, surveys, and review workflows.

### Acceptance gate

- Clinical records preserve author, patient, company, timestamps, and audit history.
- Certificates and reports are generated from database records and can be verified.

## Phase 11 — Communication and collaboration

### Work

- Implement database-backed chat threads and messages.
- Add email composition and delivery history.
- Complete notifications, calendar events, tasks, support, and contact workflows.
- Remove static messaging data and connect unread counts to authenticated users.
- Add delivery states, retry behavior, and safe failure messages.

### Acceptance gate

- Users can access only conversations and events they belong to.
- Failed external deliveries are visible to authorized staff and can be retried safely.

## Phase 12 — External integrations

Enable integrations one provider at a time after the internal workflows are complete.

### Order

1. SMTP email delivery.
2. Africa's Talking SMS.
3. MTN MoMo, Airtel Money, and M-Pesa.
4. Insurance providers.
5. National ID providers.
6. LIS/FHIR exchange.
7. NMS, KEMSA, and MSD supply chains.
8. Ambulance GPS.
9. Twilio emergency calling.

### Work

- Enforce every feature flag in controllers and services.
- Fail closed when a production feature is enabled without valid credentials.
- Separate sandbox and production endpoints.
- Validate callback signatures, replay protection, timestamps, and idempotency keys.
- Add provider contract tests using faked HTTP responses, followed by sandbox tests and documented production verification.
- Never present mock responses as successful live provider operations.

### Acceptance gate

- Each provider has a tested sandbox flow, failure handling, observability, and a verified production callback.
- Secrets remain only in the deployment environment.

## Phase 13 — Scheduler, queues, backups, and operations

### Work

- Implement the missing `meditrack:*` Artisan commands referenced in `routes/console.php`:
  - clean expired tokens;
  - expire lab results;
  - send appointment reminders;
  - check low stock;
  - sync ambulance GPS;
  - anonymize expired records;
  - delete old audit logs;
  - health check and alerting.
- Configure Alwaysdata cron to run `php artisan schedule:run` every minute.
- Move production from the synchronous queue to a supported persistent queue and supervise workers.
- Configure real mail delivery.
- Configure and test encrypted backups, retention, off-site storage, restore, and failure notification.
- Update the health endpoint so required and intentionally disabled services are reported accurately.
- Generate and publish Scribe API documentation.

### Acceptance gate

- Scheduler and queue jobs are observed running in production.
- A backup is restored successfully into an isolated database and storage location.
- The production health endpoint reports healthy, or clearly identifies an intentionally optional service without marking the whole application degraded.

## Phase 14 — Quality, accessibility, and release readiness

### Work

- Add feature tests for every API resource and status transition, concentrating on the 290 registered API routes that currently have limited coverage.
- Add authenticated browser tests for each critical Blade workflow.
- Add desktop and phone visual-regression coverage for the shared shell and primary reference screens.
- Test keyboard navigation, focus management, labels, contrast, empty states, validation, and destructive confirmations.
- Load-test dashboard queries, search, reports, imports, exports, and large patient histories.
- Fix PHP deprecations and resolve Composer security advisories.
- Align README and SETUP documentation with the actual Laravel and Blade implementation.
- Merge the release branch into `main` so the repository's deployment source matches the live release.

### Final release gate

- Complete test suite and production cache checks pass on PHP 8.3.
- No high-severity authorization, tenant-isolation, dependency, or data-integrity findings remain.
- Critical workflows pass on desktop and phone against production-like data.
- Live login, assets, authenticated dashboards, CRUD persistence, queues, scheduler, mail, backups, and provider callbacks are independently verified.

## Recommended milestone grouping

| Milestone | Phases | Deliverable |
|---|---:|---|
| Secure core | 0–1 | Tenant-safe shared Laravel and Blade foundation |
| Hospital front desk | 2–3 | Appointments, scheduling, staff, departments, services, and roles |
| Clinical operations | 4–5 | Laboratory, prescriptions, pharmacy, dispensing, and stock safety |
| Revenue cycle | 6 | Invoices, receipts, insurance, payments, and reconciled reports |
| Hospital operations | 7–9 | Inventory, facilities, surgery, radiology, blood bank, and ambulance |
| Extended care | 10–11 | Remaining clinical records, communication, and collaboration |
| Production readiness | 12–14 | Real integrations, jobs, backups, documentation, testing, and release |

## Current first sprint

Start with this bounded sequence:

1. Add company-scoped queries and policy authorization to patient, doctor, appointment, invoice, staff, lab, pharmacy, report, and dashboard web controllers.
2. Add cross-company and denied-role tests.
3. Build appointment create, edit, show, reschedule, confirm, cancel, and complete workflows in Blade.
4. Build doctor availability and conflict detection.
5. Replace appointment-related legacy placeholders with native redirects.
6. Verify the complete appointment journey at desktop and phone widths.
