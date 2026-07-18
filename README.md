# MediTrack Healthcare — Hospital Management System

**Excellence in Healthcare Management**

A Laravel 11 hospital-management application with a static demo frontend for East African workflows (Uganda, Kenya, Tanzania, Rwanda, Burundi, South Sudan, and Ethiopia). It includes the core HMS modules and integration adapters; external SMS, payment, identity, and laboratory providers require deployment credentials.

> The GitHub repository name and URL are preserved as `nathantugume/hospital`. The existing `https://hospital.alwaysdata.net` deployment is still the previous Hospital project until this MediTrack release is deployed separately.

---

## Table of Contents

1. [Overview](#overview)
2. [Features](#features)
3. [Technology Stack](#technology-stack)
4. [Frontend Architecture](#frontend-architecture)
5. [Backend Architecture](#backend-architecture)
6. [East African Integrations](#east-african-integrations)
7. [Security & Compliance](#security--compliance)
8. [Multi-Language Support](#multi-language-support)
9. [Charts & Reports](#charts--reports)
10. [PDF Generation](#pdf-generation)
11. [Setup & Installation](#setup--installation)
12. [Default Credentials](#default-credentials)
13. [API Documentation](#api-documentation)
14. [Testing](#testing)
15. [Deployment](#deployment)

---

## Overview

MediTrack Healthcare is a full-featured HMS built for East African hospitals. It covers patient management, appointments, billing, lab, pharmacy, radiology, surgery, blood bank, ambulance, inventory, payroll, insurance, and more — all localized for East African names, locations, currencies (UGX/KES/TZS/RWF), phone formats, and number plates.

- **209 HTML pages** with Tailwind CSS + ApexCharts
- **49 database tables** with proper foreign keys, indexes, and encrypted PII
- **66 Eloquent models** with relationships
- **53 API controllers** + 60 Form Request validation classes
- **29 Policy classes** for RBAC
- **9 East African integration services** (SMS, Mobile Money, Insurance, NIRA, LIS, NMS/KEMSA, GPS, Twilio)
- **18 user roles** with role-specific dashboards

## Features

### Core Modules
- **Patient Management** — Registration, profiles, medical history, consents, insurance
- **Appointments** — Booking, calendar, reminders, rescheduling, requests
- **Billing & Invoices** — Invoice creation, payments (MTN MoMo/Airtel/M-Pesa), receipts
- **Laboratory** — Test requests, sample collection, result entry, abnormal flagging, FHIR R4
- **Pharmacy** — Medicine catalog, batches, prescriptions, dispensing, stock transactions
- **Radiology** — Orders, scheduling, PACS viewer (DICOM), reporting
- **Surgery/OT** — Scheduling, surgeon assignment, status tracking
- **Blood Bank** — Donors, units, issues, compatibility
- **Ambulance** — Fleet management, call dispatch, GPS tracking, severity triage
- **Inventory** — Items, suppliers, purchase orders, transfers, stock alerts
- **Rooms & Wards** — Room allotment, bed occupancy, department grouping
- **Payroll** — Salary management, payslips, deductions
- **Insurance** — Claims, pre-authorization, provider verification
- **Birth & Death Records** — Certificate generation, verification
- **Vaccinations** — Immunization tracking, schedules
- **Physiotherapy** — Sessions, treatment plans, exercises
- **Staff Management** — Attendance, leaves, certifications, performance reviews
- **Super-Admin** — Multi-tenant SaaS, roles, permissions, audit logs

### System-Wide Features
- **Single source of truth** — All modules share data via MeditrackStore (localStorage) + Laravel DB
- **Cross-page data sync** — Changes on one page reflect instantly on all others
- **Toast notifications** — Success/error feedback on every action
- **Confirmation modals** — All Cancel/Back/Return buttons confirm before navigating
- **Pagination** — All tables paginated with sortable columns
- **Search** — All search inputs filter tables in real-time
- **Print/Export** — CSV, PDF (with hospital branding), print-friendly views
- **Dark mode** — System-wide dark theme support
- **Responsive** — Mobile-friendly layouts

## Technology Stack

| Layer | Technology |
|---|---|
| Frontend | HTML5, Tailwind CSS, ApexCharts, vanilla JS (29 modules) |
| Backend | PHP 8.2+, Laravel 11, Sanctum, Fortify |
| Database | MySQL 8 (default) / PostgreSQL / SQLite (testing) |
| Cache/Queue | Redis 7, Laravel Horizon |
| HTTP Server | Nginx + PHP-FPM / Laravel Octane (Swoole) |
| Auth | Sanctum (httpOnly cookies) + Fortify (2FA, email verify) |
| Security | Application security headers, spatie/activitylog, spatie/laravel-backup |
| API Docs | Scribe |
| Testing | PHPUnit 11 |
| CI/CD | GitHub Actions |

## Frontend Architecture

### JavaScript Modules (29 files in `js/`)

| File | Purpose |
|---|---|
| `meditrack.js` | Core: Toast, validation, confirm, API wrapper, RBAC, auth guard |
| `meditrack-store.js` | Centralized CRUD data store (single source of truth) |
| `meditrack-security.js` | DOMPurify XSS sanitizer, innerHTML auto-patch |
| `meditrack-nav-confirm.js` | Cancel/Back/Return confirmation popovers |
| `meditrack-avatars.js` | Replaces initials avatars with user.png |
| `meditrack-apex-data.js` | Injects real data into ApexCharts instances |
| `meditrack-pdf.js` | 14 branded PDF generators (jsPDF + autotable) |
| `meditrack-pagination.js` | Table pagination with sortable columns |
| `meditrack-search.js` | Real-time table search filtering |
| `meditrack-language.js` | Multi-language translation (LibreTranslate + MyMemory) |
| `meditrack-consent.js` | GDPR/DPPA consent tracking for patient registration |
| `admin-sync.js` | Cross-page admin data sync (departments, staff, roles) |
| `clinical-sync.js` | Cross-page clinical data sync (patients, appointments, etc.) |
| `messaging-sync.js` | Email + Chat functional wiring |
| `core/theme.js` | Dark mode toggle |
| `core/sidebar.js` | Sidebar navigation |
| `core/notifications.js` | Notification center |
| `core/profile.js` | User profile dropdown |
| `features/settings-manager.js` | Clinic settings, currency, exchange rates |
| `features/currency.js` | Multi-currency (UGX/KES/TZS/RWF) formatting |
| `features/regional.js` | Regional formatting (dates, numbers) |
| `features/appointments.js` | Appointment-specific logic |
| `features/language.js` | Legacy language helpers |
| `features/tabs.js` | Tab navigation |
| `features/pip-widget.js` | Picture-in-picture video call widget |
| `features/calendar-preferences.js` | Calendar view preferences |
| `init.js` | Module loader (initializes all modules) |
| `utils.js` | Utility functions |

### ApexCharts — Real Data
The frontend uses **ApexCharts** (loaded from CDN) for all dashboard charts. The `meditrack-apex-data.js` module hooks into existing ApexCharts instances and replaces hardcoded dummy data with real data from `MeditrackStore`. The original chart appearance (gradients, area fills, tooltips) is preserved exactly.

### 3-Dot Action Menu
All table rows use the original **3-dot action menu** pattern (vertical dots button → dropdown with entity-specific actions like View Profile, Medical History, Prescriptions, Delete). This matches the original frontend design exactly.

## Backend Architecture

### Database (49 tables)
- **Auth**: users, password_reset_tokens, sessions
- **SaaS**: companies, subscriptions, purchase_transactions
- **Patients**: patients, patient_emergency_contacts, patient_insurances, patient_consents
- **Staff**: staff, staff_certifications, staff_education, staff_attendance, staff_timesheets, staff_leaves, staff_reviews, patient_feedback
- **Departments**: departments, wards
- **Appointments**: appointments, appointment_requests
- **Billing**: invoices, invoice_items, invoice_services
- **Insurance**: insurance_providers, insurance_claims, claim_services, insurance_communications
- **Lab**: lab_tests, test_requests, lab_request_tests, lab_results, lab_result_items, lab_equipment
- **Pharmacy**: medicines, medicine_batches, medicine_transactions, prescriptions, prescription_items, medication_administrations
- **Inventory**: inventory_items, suppliers, supplier_products, purchase_orders, order_tracking_events, inventory_transfers, inventory_transfer_items, inventory_transfer_dispatches
- **Clinical**: radiology_orders, surgeries, rooms, room_allotments
- **Blood Bank**: blood_donors, blood_units, blood_donations, blood_issues
- **Ambulance**: ambulances, ambulance_calls, ambulance_gps_positions
- **Records**: birth_records, death_records
- **Services**: services, service_availability, service_providers
- **Payroll**: payroll_entries, payslips
- **Physiotherapy**: physiotherapy_sessions
- **Vaccinations**: vaccinations
- **Communication**: calendar_events, notifications, chat_threads, chat_messages
- **Super-Admin**: role_assignments, role_change_log, audit_logs
- **Integration**: sms_logs, mobile_money_transactions, national_id_verifications

### Security Measures
- **PII Encryption**: 12 models use `encrypted` cast for phone, email, national_id, medical_history
- **Mass Assignment Protection**: All 66 models use `$fillable` (never `$guarded`)
- **Form Requests**: 60 validation classes for all POST/PUT/PATCH endpoints
- **Policies**: 29 policy classes with viewAny/view/create/update/delete/restore/forceDelete
- **Gates**: 32 role-based gates + 17 combined permission gates
- **Rate Limiting**: 5/min login, 3/hour register, 60/min API, 5/min 2FA
- **Security Headers**: HSTS, X-Frame-Options: DENY, X-Content-Type-Options, CSP, Referrer-Policy, Permissions-Policy
- **CORS**: Restricted to `CORS_ALLOWED_ORIGINS` env variable
- **Sanctum**: 30-day token expiration, httpOnly cookie support
- **Fortify**: 2FA (TOTP + recovery codes), email verification, password reset with signed URLs
- **Audit Trail**: spatie/activitylog on all 66 models + dedicated audit_logs table
- **Backup**: spatie/laravel-backup with nightly schedule + 5-year retention

## East African Integrations

| Service | Class | Coverage |
|---|---|---|
| SMS Gateway | `AfricasTalkingService` | UG, KE, TZ, RW, BI, ET, SS |
| MTN MoMo | `MomoService` | Uganda (collections + disbursements) |
| Airtel Money | `AirtelMoneyService` | Uganda |
| M-Pesa | (config in services.php) | Kenya (Safaricom) |
| Insurance | `InsuranceService` | UAP, Jubilee, ICEA, Britam, Sanlam, NHIF KE, NHIF TZ, RSSB RW |
| National ID | `NiraService` | NIRA (UG), NIIMS (KE), NIDA (TZ), NIDA Rwanda |
| LIS | `LisService` | HL7 v2.5 + FHIR R4 DiagnosticReport |
| Pharmacy Supply | `PharmacySupplyChainService` | NMS (UG), KEMSA (KE), MSD (TZ) |
| GPS Tracking | `AmbulanceTrackingService` | OnTrack + webhook support |
| Emergency Voice | `TwilioService` | Triage alerts, ambulance dispatch |

All services degrade gracefully — if credentials are missing, they return mock responses for testing.

## Security & Compliance

### GDPR / DPPA Compliance
- **Right to Access**: `GET /api/v1/patients/{id}/data-export` — downloads all patient data as JSON
- **Right to Erasure**: `DELETE /api/v1/patients/{id}/erase` — anonymizes PII, retains clinical records 7 years per DPPA Section 43
- **Consent Management**: `GET/POST /api/v1/patients/{id}/consents` — track data_protection, treatment, financial consents
- **Privacy Policy**: `GET /api/v1/privacy-policy` — machine-readable policy
- **Retention Policy**: `GET /api/v1/data-retention-policy` — 7-year retention schedule

### Backup
- Nightly full backup at 2:00 AM (database + files)
- Retention: 7 days all → 16 days daily → 8 weeks weekly → 4 months monthly → 5 years yearly
- Max 5GB per backup
- Email notifications on success/failure

## Multi-Language Support

The HMS supports 6 languages via `meditrack-language.js`:

| Language | Code | Countries |
|---|---|---|
| English | `en` | Default |
| Kiswahili | `sw` | Kenya, Tanzania, Uganda |
| Luganda | `lg` | Uganda |
| Kinyarwanda | `rw` | Rwanda |
| Français | `fr` | Burundi, DRC |
| العربية | `ar` | South Sudan |

**Translation providers** (in priority order):
1. **LibreTranslate** — free, open-source API (no key required)
2. **MyMemory** — free EU-based API (5000 words/day)
3. **Google Translate widget** — fallback for full-page translation

**Features**:
- Language selector auto-injected into every page header
- Translates all text nodes, input placeholders, and title attributes
- 7-day translation cache in localStorage
- Remembers user's language choice across pages
- Batch translation (5 strings at a time to respect rate limits)

## Charts & Reports

### ApexCharts (Original Look Preserved)
All dashboard charts use **ApexCharts** with real data from MeditrackStore:
- Revenue trend (area chart with gradient fill)
- Patient demographics (bar chart — Male vs Female by age group)
- Appointment types (donut chart)
- Revenue sources (donut — Insurance/Cash/Mobile Money)
- Bed occupancy (area chart)
- Lab tests by department (bar chart)
- Staff by department (bar chart)
- Blood units by type (donut chart)
- Surgeries by status (donut chart)

### KPI Counters
All dashboard stat counters (Total Patients, Revenue, Appointments, etc.) auto-update from real store data.

### Auto-Refresh
Charts and KPIs refresh every 30 seconds + on store changes.

## PDF Generation

14 branded PDF generators with professional hospital branding:

**Header (every page)**: Logo, "MediTrack Healthcare", tagline, website, phone, location, separator line

**Footer (every page)**: Page X of Y, generation timestamp, "CONFIDENTIAL MEDICAL DOCUMENT" disclaimer, separator line

**Generators**:
1. Invoice (with items table, totals, payment instructions, QR code)
2. Receipt (with amount-paid box, QR code)
3. Lab Report (with results table, color-coded flags, signatures, QR code)
4. Prescription (℞ symbol, medications table, warning footer, QR code)
5. Discharge Summary (diagnosis, treatment, follow-up instructions)
6. Payslip (earnings/deductions table, net pay box, QR code)
7. Stock Report (landscape, all inventory items)
8. Appointment Confirmation (with QR code)
9. Referral Letter (formal letter format)
10. Insurance Claim (services table, signatures)
11. Birth Certificate (decorative border, cert number, QR code)
12. Death Certificate (formal format, cert number, QR code)
13. Financial Statement (summary + invoice breakdown)
14. Generic Table PDF (exports any table on the current page)

## Setup & Installation

### Docker (Recommended)

```bash
cd laravel
cp .env.example .env
docker-compose up -d --build
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --seed
docker-compose exec app php artisan scribe:generate
```

Access:
- Frontend: http://localhost:8080/
- API health: http://localhost:8080/api/v1/health
- API docs: http://localhost:8080/docs
- Horizon: http://localhost:8080/horizon

### Local (without Docker)

```bash
cd laravel
cp .env.example .env
composer install
php artisan key:generate
# Edit .env with DB + Redis credentials
php artisan migrate --seed
php artisan storage:link
php artisan horizon
php artisan octane:start --server=swoole --port=8000
```

## Default Credentials

All passwords: `password123`

| Role | Email | Dashboard |
|---|---|---|
| Super Admin | `superadmin@meditrack.com` | super-admin.html |
| Admin | `admin@meditrack.com` | index.html |
| Doctor | `doctor@meditrack.com` | doctor-dashboard.html |
| Nurse | `nurse@meditrack.com` | nurse-station.html |
| Business | `business@meditrack.com` | business-dashboard.html |
| Patient | `patient@meditrack.com` | patient-dashboard.html |
| Receptionist | `receptionist@meditrack.com` | appointments.html |
| Lab Tech | `lab@meditrack.com` | lab-dashboard.html |
| Pharmacist | `pharmacist@meditrack.com` | medicine.html |
| Accountant | `accountant@meditrack.com` | billing.html |
| + 8 more roles | See login.html | |

## API Documentation

Base URL: `http://localhost:8000/api/v1`

All protected routes require `Authorization: Bearer {token}` header (or httpOnly cookie).

### Key Endpoints
- `POST /auth/login` — Login (returns token + user)
- `POST /auth/register` — Register new patient
- `GET /auth/me` — Current user profile
- `POST /auth/2fa-challenge` — 2FA verification
- `GET /health` — System health check (public)
- `GET /patients` — List patients (paginated)
- `POST /patients` — Create patient
- `GET /patients/{id}/data-export` — GDPR data export
- `DELETE /patients/{id}/erase` — GDPR right to erasure
- `GET /privacy-policy` — Privacy policy (public)
- `GET /data-retention-policy` — Retention schedule (public)

### Response Format
```json
{
  "success": true,
  "message": "OK",
  "data": { ... },
  "meta": { "current_page": 1, "per_page": 15, "total": 60 }
}
```

### Error Format
```json
{
  "success": false,
  "message": "Validation failed.",
  "errors": { "field": ["Error message."] }
}
```

## Testing

```bash
# Run all tests
php artisan test

# With coverage
php artisan test --coverage --min=80

# Run specific test
php artisan test --filter=PatientCrudTest
```

### Test Files
- `tests/Feature/Auth/LoginTest.php` — Login flows, rate limiting, 2FA
- `tests/Feature/RBAC/RoleBasedAccessTest.php` — Role-based access control
- `tests/Feature/Patients/PatientCrudTest.php` — Patient CRUD + validation
- `tests/Feature/Billing/InvoiceWorkflowTest.php` — Invoice + payment workflow
- `tests/Feature/Security/SecurityHeadersTest.php` — Security headers, CORS, throttle
- `tests/Unit/ServicesTest.php` — Service instantiation + mock responses

### CI/CD
GitHub Actions (`.github/workflows/ci-cd.yml`) runs on every push, pull request, and manual dispatch:
- **quality** job: PHP 8.3, Composer validation/install, PHP syntax checks, Laravel config/route/view cache validation, the complete PHPUnit suite, and a Composer advisory report
- **deploy** job: runs after quality for pushes to `main` or manual dispatch, publishes an immutable release to Alwaysdata, runs migrations against production MySQL, caches Laravel configuration/routes/views, and smoke-tests protected home access, login, CSS assets, and API health

Configure these GitHub secrets for production deployment:
`LARAVEL_APP_KEY`, `ALWAYSDATA_SSH_HOST`, `ALWAYSDATA_SSH_USER`, `ALWAYSDATA_SSH_PASSWORD`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.

CI intentionally uses an in-memory SQLite database for deterministic tests. The deployed application uses MySQL on Alwaysdata; set the `DB_*` secrets to the production database credentials and host.

## Deployment

### Environment Files
- `.env.example` — Template (copy to `.env`)
- `.env.testing` — PHPUnit/CI (SQLite in-memory, sandbox credentials)
- `.env.staging` — Pre-production (S3, Mailtrap, sandbox integrations)
- `.env` — Production (set all credentials, enable HSTS + CSP)

### Production Checklist
1. Set `APP_ENV=production`, `APP_DEBUG=false`
2. Set `APP_URL` to production domain
3. Set `CORS_ALLOWED_ORIGINS` to production frontend URL
4. Set `DB_PASSWORD` to a strong password
5. Set `REDIS_PASSWORD`
6. Set all integration API keys (Africa's Talking, MTN MoMo, etc.)
7. Set `BACKUP_ARCHIVE_PASSWORD`
8. Run `php artisan config:cache && php artisan route:cache`
9. Set up Supervisor for queue workers
10. Configure Nginx with SSL (Let's Encrypt)
11. Set up cron: `* * * * * cd /var/www/meditrack && php artisan schedule:run`
12. Run first backup: `php artisan backup:run`

### Docker Production
```bash
docker-compose -f docker-compose.prod.yml up -d --build
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan horizon:terminate  # restart workers
```

---

**MediTrack Healthcare** — Excellence in Healthcare Management  
www.meditrack-healthcare.com • Kampala, Uganda • +256-414-100-100
