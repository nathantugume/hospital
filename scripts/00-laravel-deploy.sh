#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

echo "Installing Composer dependencies..."
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

echo "Caching Laravel configuration..."
php artisan config:cache

echo "Caching Laravel routes..."
php artisan route:cache

echo "Running database migrations..."
php artisan migrate --force
