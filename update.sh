#!/bin/bash
set -e

echo "==> Pulling latest changes..."
git pull origin main

echo "==> Building container..."
docker compose build app

echo "==> Restarting container (skip DB migrate/seed)..."
APP_SKIP_DB=true docker compose up -d

echo "==> Fixing file permissions..."
# Kembalikan ownership proyek ke user host agar file bisa diedit
sudo chown -R ravaa:ravaa /var/www/RavaaWeb
# Kembalikan ownership storage/framework ke www-data agar Laravel bisa write cache
# Tanpa ini, BladeCompiler akan error: touch(): Utime failed: Operation not permitted
docker compose exec -T app chown -R www-data:www-data /var/www/html/storage/framework

echo "==> Done!"
docker ps --filter "name=RavaaWeb-prod" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
