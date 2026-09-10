# Project guidance

## Project and source of truth

- This is MediTrack HMS, a Laravel 11 / PHP 8.2+ hospital management application, not a Flutter project. Composer targets PHP 8.3 and CI uses PHP 8.3.
- Inspect the actual routes, controllers, migrations, models, and views before changing behavior. README.md and SETUP.md contain older static-demo descriptions and are not proof that a feature is implemented or deployed.
- Preserve existing unrelated changes. Do not edit generated dependencies in vendor/.

## Code map

- routes/web.php: authenticated web routes, role restrictions, and legacy URL handling.
- routes/api.php: API routes; inspect their middleware and controllers before changing contracts.
- app/Http/Controllers/Web/ and app/Http/Controllers/Api/: web and API implementations.
- app/Http/Requests/, app/Policies/, app/Models/, and app/Services/: validation, authorization, persistence, and integrations.
- database/migrations/, database/factories/, and database/seeders/: schema and test/demo data.
- resources/views/: current Blade screens; layouts/app.blade.php and partials/ provide the shared shell.
- public/style.css and public/blade.css: frontend styles. public/js/ retains the static frontend scripts; check actual script inclusion before editing them.
- tests/Feature/ and tests/Unit/: automated coverage. tests/Feature/Web/ covers Blade pages and web CRUD.
- .github/workflows/ci-cd.yml and scripts/deploy-direct.sh: release tooling.

## Reference HTML template

- Verified local reference archive: /home/nathan/Downloads/meditrack-hms.zip.
- /home/nathan/Downloads/meditrack-hms (1).zip is byte-for-byte identical as checked on 2026-09-08.
- The archive contains 209 HTML pages under public/, including public/index.html, public/patients.html, and public/login.html, with supporting CSS, JavaScript, and images.
- Archive SHA-256: 2488815b70525aa0422ba7e91a2c74011fee1b4bdde9866214694cd7e80d2a3c.
- The archive's public/style.css exactly matches the project's public/style.css; public/patients.html exactly matches resources/views/legacy/patients.blade.php. These establish its connection to this checkout; external vendor provenance has not been verified.
- resources/views/legacy/ retains reference markup. Consult it and the archive when matching the original design. Extract previews outside public/ and preserve relative asset paths.
- Current screens are the active Blade views, not the archived HTML. LegacyPageController currently checks whether a legacy view exists and returns coming-soon; /index.html redirects to the dashboard. Do not assume a legacy page is an implemented feature.
- Preserve the reference layout, navigation, typography, table actions, and responsive behavior where applicable while connecting screens to real Laravel data.

## Implementation conventions

- Follow nearby Laravel conventions, named routes, Form Requests, Eloquent relationships, and policies. Enforce authorization on the server as well as in the UI.
- Preserve role and company/tenant boundaries wherever implemented. Cover denied access as well as successful workflows when changing permissions.
- Use database-backed application flows for real records. Legacy localStorage/demo scripts are not evidence of backend persistence.
- Keep Blade output escaped, preserve CSRF protection, and validate writes. Preserve encrypted model casts and audit behavior when handling patient data.
- Keep secrets, patient records, database contents, and integration credentials out of commits and logs. Do not regenerate an existing APP_KEY: encrypted records may depend on it.
- Use additive migrations for schema changes. Never reset, reseed, or replace an existing database as a routine setup step.

## Local work and validation

- Install locked dependencies with composer install when needed. The web frontend uses directly served assets; there is no root package.json build workflow.
- Start local development with php artisan serve. Use an isolated local environment/database; do not overwrite the existing .env.
- Run targeted tests first, for example: php artisan test --filter=BladeWebTest or php artisan test tests/Feature/Web/PatientCrudTest.php.
- For broader backend changes, run php artisan test --without-tty. phpunit.xml configures SQLite :memory: with array cache/session/mail and a synchronous queue; verify the effective test environment is isolated before database tests.
- Use php -l on changed PHP files; use composer validate --strict when changing Composer metadata.
- CI also checks config/route/view caching and route registration. Run cache-mutating checks only in a suitable local/test environment and clear generated caches afterward.
- Verify UI changes in the rendered authenticated application at phone and desktop widths. Check navigation, forms, validation messages, and persistence for the changed workflow.
- Documentation-only edits need a diff/format review, not an application test suite. Report exactly which checks ran and any unverified behavior.

## Releases

- CI is configured to deploy to Alwaysdata on a main-branch push or manual workflow dispatch after quality checks; treat those actions as deployment triggers.
- Do not infer current production state from README.md or a successful local test. For an authorized release, verify the actual deployment and live routes separately from local validation.
