# Multi-stage Dockerfile for Meditrack HMS Laravel backend
# PHP 8.2 FPM + Nginx + Supervisor (queue worker + horizon)

# ============================================================
# Stage 1: Build vendor dependencies
# ============================================================
FROM composer:2.7 as composer
WORKDIR /app
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist
COPY . .
RUN composer dump-autoload --optimize --no-dev

# ============================================================
# Stage 2: Final production image
# ============================================================
FROM php:8.2-fpm-alpine

# System dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libxml2-dev \
    oniguruma-dev \
    icu-dev \
    mysql-client \
    redis \
    nodejs \
    npm

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_pgsql \
        mysqli \
        zip \
        gd \
        mbstring \
        xml \
        bcmath \
        intl \
        pcntl \
        opcache \
        exif

# Swoole for Octane
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers \
    && pecl install swoole \
    && docker-php-ext-enable swoole \
    && apk del .build-deps

# Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Set working directory
WORKDIR /var/www/html

# Copy application
COPY --from=composer /app /var/www/html
COPY . /var/www/html

# Copy frontend into public/
# (the frontend is placed in /public by the deploy script)

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache public

# Nginx config
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# PHP config
RUN echo "memory_limit = 512M" > /usr/local/etc/php/conf.d/memory.ini \
    && echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 300" > /usr/local/etc/php/conf.d/max-exec.ini

EXPOSE 80 443 8000

# Start supervisor (manages nginx + php-fpm + queue worker + horizon)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
