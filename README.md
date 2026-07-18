# Hospital

Hospital is a Laravel appointment-management app with doctor records, appointment booking, admin appointment views, Jetstream/Fortify authentication, and email notification flow.

[![CI/CD](https://github.com/nathantugume/hospital/actions/workflows/ci-cd.yml/badge.svg)](https://github.com/nathantugume/hospital/actions/workflows/ci-cd.yml)

## Live Demo

- Application: https://hospital.alwaysdata.net
- Login: https://hospital.alwaysdata.net/login

[![Deploy to Render](https://render.com/images/deploy-to-render-button.svg)](https://render.com/deploy?repo=https://github.com/nathantugume/hospital)

## Requirements

- PHP 8.2+
- Composer
- Node.js and npm, if rebuilding frontend assets
- MySQL, MariaDB, PostgreSQL, or SQLite for local development

## Local Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

## Render Deployment

This repository includes:

- `Dockerfile` for Render Docker deployment
- `render.yaml` for a free Render web service and free Render Postgres database
- `scripts/00-laravel-deploy.sh` to install production dependencies, cache Laravel config/routes, and run migrations

Before approving the Render blueprint, set these environment variables in Render:

- `APP_KEY`: generate with `php artisan key:generate --show` locally, or `printf 'base64:' && openssl rand -base64 32`
- `APP_URL`: the Render service URL after creation
- `ASSET_URL`: the same Render service URL

The default Render blueprint logs outgoing mail with `MAIL_MAILER=log`. Replace the mail settings in Render if you want real appointment emails.

Render free Postgres databases expire after 30 days, and free web-service filesystems are ephemeral. Uploaded doctor images should be moved to object storage before using this as a long-lived production app.

## GitHub Actions CI/CD

Pull requests run Composer validation, PHP syntax checks, Laravel tests, and the Vite production build. A push to `main` or a manual workflow run deploys a versioned release to Alwaysdata after those checks pass.

Configure these GitHub Actions secrets before the first deployment:

- `ALWAYSDATA_SSH_HOST`: `ssh-hospital.alwaysdata.net`
- `ALWAYSDATA_SSH_USER`: `hospital`
- `ALWAYSDATA_SSH_PASSWORD`: the Alwaysdata SSH password
- `LARAVEL_APP_KEY`: a stable Laravel key such as the output of `php artisan key:generate --show`

The deployment uses the persistent SQLite database and storage paths under `/home/hospital/shared`, keeps previous releases available for rollback, and verifies both the homepage and login route after publishing.
