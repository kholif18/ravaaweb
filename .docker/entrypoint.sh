#!/bin/bash
set -e

# ------------------------------------------------------------
# RavaaWeb — Entrypoint (Production & Development)
# ------------------------------------------------------------

IS_DEV=false
if [ "$APP_ENV" = "local" ] || [ "$APP_DEBUG" = "true" ]; then
    IS_DEV=true
fi

# --- Generate APP_KEY jika belum diset ---
if [ -z "$APP_KEY" ] || [[ "$APP_KEY" != base64:* ]]; then
    echo "==> WARNING: APP_KEY tidak ditemukan. Mengenerate key sementara..."
    php artisan key:generate --force --quiet
    export APP_KEY=$(php -r 'echo config("app.key");')
fi

# --- Composer install (hanya jika vendor kosong, e.g. first dev run) ---
if [ ! -f vendor/autoload.php ]; then
    echo "==> vendor/autoload.php not found — running composer install..."
    composer install --no-interaction --no-progress
fi

if [ "$IS_DEV" = true ]; then
    # --- Development: skip optimizations (agar perubahan langsung terlihat) ---
    echo "==> [DEV] Skipping optimizations..."
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
else
    # --- Production: optimizations ---
    echo "==> Running Laravel optimizations..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
fi

# --- Database ---
if [ "$APP_SKIP_DB" != "true" ]; then
    echo "==> Running migrations..."
    php artisan migrate --force

    if [ "$IS_DEV" = false ]; then
        echo "==> Running seeders..."
        php artisan db:seed --force
    fi
else
    echo "==> APP_SKIP_DB=true — skipping migrations & seeders..."
fi

# --- Storage ---
php artisan storage:link --force || true

# --- Start Apache ---
echo "==> Starting Apache..."
exec apache2-foreground
