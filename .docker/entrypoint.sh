#!/bin/bash
set -e

# ------------------------------------------------------------
# RavaaWeb Production Entrypoint
# Runs Laravel optimization & migration on container start
# ------------------------------------------------------------

echo "==> Running Laravel optimizations..."

# Cache Laravel config (must come first — all other caches depend on it)
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache Blade templates
php artisan view:cache

# Cache events (if any listeners defined)
php artisan event:cache

# Run migrations (idempotent — won't re-run already-applied migrations)
php artisan migrate --force

# Create storage symlink if not exists
php artisan storage:link --force

echo "==> Starting Apache..."

# Start Apache in foreground
exec apache2-foreground
