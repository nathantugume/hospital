# MediTrack HMS — Setup Guide for VS Code

## Prerequisites

### 1. Install PHP 8.2+
- **Windows**: Download from https://windows.php.net/download/ (Non Thread Safe)
  - Extract to `C:\php`
  - Add `C:\php` to your PATH environment variable
- **Mac**: `brew install php`
- **Linux**: `sudo apt install php8.2 php8.2-cli php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-sqlite3 php8.2-gd php8.2-bcmath php8.2-intl`
- Verify: `php -v` should show PHP 8.2+

### 2. Install Composer
- Download from https://getcomposer.org/download/
- Verify: `composer --version`

### 3. Install VS Code
- Download from https://code.visualstudio.com/
- Install extensions: PHP Intelephense, Tailwind CSS IntelliSense, Live Server

## Setup Steps

### Step 1: Open the project in VS Code
File → Open Folder → select the `laravel/` directory

### Step 2: Install PHP dependencies
```bash
composer install
```

If you get errors about missing PHP extensions:
```bash
# Linux:
sudo apt install php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-sqlite3 php8.2-gd php8.2-bcmath php8.2-intl

# Windows: edit C:\php\php.ini and uncomment:
# extension=mbstring, extension=xml, extension=curl, extension=zip, extension=sqlite3, extension=gd, extension=bcmath, extension=intl
```

### Step 3: Generate application key
```bash
php artisan key:generate
```

### Step 4: Run database migrations (creates all 49 tables)
```bash
php artisan migrate
```

### Step 5: Seed the database with East African test data
```bash
php artisan db:seed
```

### Step 6: Start the development server
```bash
php artisan serve
```

### Step 7: Open in your browser
- **Frontend**: http://localhost:8000/
- **Login**: `admin@meditrack.com` / `password123`
- **API health check**: http://localhost:8000/api/v1/health
- **API docs** (after scribe:generate): http://localhost:8000/docs

## Default Login Accounts (all passwords: `password123`)

| Role | Email | Dashboard |
|---|---|---|
| Super Admin | superadmin@meditrack.com | super-admin.html |
| Admin | admin@meditrack.com | index.html |
| Doctor | doctor@meditrack.com | doctor-dashboard.html |
| Nurse | nurse@meditrack.com | nurse-station.html |
| Business | business@meditrack.com | business-dashboard.html |
| Patient | patient@meditrack.com | patient-dashboard.html |
| Receptionist | receptionist@meditrack.com | appointments.html |
| Lab Tech | lab@meditrack.com | lab-dashboard.html |
| Pharmacist | pharmacist@meditrack.com | medicine.html |
| Accountant | accountant@meditrack.com | billing.html |
| + 8 more | See login.html | |

## Common Errors and Fixes

### "could not find driver"
Install the PHP database extension:
```bash
sudo apt install php8.2-sqlite3   # for SQLite
sudo apt install php8.2-mysql     # for MySQL
```

### "No application encryption key"
```bash
php artisan key:generate
```

### "Class not found"
```bash
composer dump-autoload
```

### "Permission denied" (storage)
```bash
chmod -R 775 storage bootstrap/cache
```

### spatie packages not found
```bash
composer require spatie/laravel-activitylog spatie/laravel-backup spatie/laravel-security-headers
```

### Horizon not found
```bash
composer require laravel/horizon
php artisan horizon:install
```

### Scribe not found
```bash
composer require knuckleswtf/scribe
```

## Using MySQL instead of SQLite

1. Edit `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=meditrack
DB_USERNAME=root
DB_PASSWORD=your_password
```

2. Create database:
```bash
mysql -u root -p -e "CREATE DATABASE meditrack;"
```

3. Run migrations:
```bash
php artisan migrate --seed
```

## Running Tests
```bash
php artisan test
```

## Generating API Documentation
```bash
php artisan scribe:generate
# Visit: http://localhost:8000/docs
```
