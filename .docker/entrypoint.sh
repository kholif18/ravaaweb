#!/bin/bash
set -e

# ------------------------------------------------------------
# RavaaWeb Production Entrypoint
# ------------------------------------------------------------

# --- Generate APP_KEY jika belum diset ---
# (Hanya fallback untuk first-run — di production sebaiknya set APP_KEY
#  di .env atau environment variable agar persist)
if [ -z "$APP_KEY" ] || [[ "$APP_KEY" != base64:* ]]; then
    echo "==> WARNING: APP_KEY tidak ditemukan. Mengenerate key sementara..."
    echo "==> Set APP_KEY di .env atau environment variable agar persist."
    php artisan key:generate --force --quiet
    # Reload env agar key baru terbaca
    export APP_KEY=$(php -r 'echo config("app.key");')
fi

# --- Laravel optimizations ---
echo "==> Running Laravel optimizations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# --- Database ---
if [ "$APP_SKIP_DB" != "true" ]; then
    echo "==> Running migrations..."
    php artisan migrate --force

    echo "==> Running seeders..."
    php artisan db:seed --force
else
    echo "==> APP_SKIP_DB=true — skipping migrations & seeders..."
fi

# --- Storage ---
php artisan storage:link --force || true

# --- Start Apache ---
echo "==> Starting Apache..."
exec apache2-foreground
