# ============================================================
# RavaaWeb — Production Multi-Stage Docker Image
# Base: PHP 8.4 + Apache
# Stages: dependencies → frontend → production
# ============================================================

# -----------------------------------------------------------
# Stage 1: PHP dependencies (Composer)
# -----------------------------------------------------------
FROM php:8.4-apache AS deps

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev libjpeg-dev libfreetype6-dev libwebp-dev libzip-dev libicu-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) pdo_mysql zip gd bcmath intl opcache

RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy only dependency files first (cache layer)
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-progress --no-scripts

# -----------------------------------------------------------
# Stage 2: Frontend build (Node)
# -----------------------------------------------------------
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci --no-audit --no-fund

COPY vite.config.js ./
COPY resources/css/ ./resources/css/
COPY resources/js/ ./resources/js/

RUN npm run build

# -----------------------------------------------------------
# Stage 3: Production image
# -----------------------------------------------------------
FROM php:8.4-apache AS production

# System deps (runtime only — no dev headers)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev libjpeg-dev libfreetype6-dev libwebp-dev libzip-dev libicu-dev \
    curl unzip \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) pdo_mysql zip gd bcmath intl opcache

RUN pecl install redis && docker-php-ext-enable redis

# Apache modules
RUN a2enmod rewrite headers expires deflate

# PHP config
COPY .docker/php.ini /usr/local/etc/php/conf.d/production.ini
COPY .docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Apache vhost
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Copy Composer dependencies from deps stage
COPY --from=deps /var/www/html/vendor ./vendor

# Copy built frontend from frontend stage
COPY --from=frontend /app/public/build ./public/build

# Copy application source (excluding dev files via .dockerignore)
COPY . .

# Generate storage link
RUN php artisan storage:link --force 2>/dev/null || true

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Entrypoint
COPY .docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl -f http://localhost/up || exit 1

ENTRYPOINT ["/entrypoint.sh"]
