#!/bin/sh
set -e

# ── Replace $PORT placeholder in Nginx config ──
# Render injects PORT as an env var; default to 10000
export PORT="${PORT:-10000}"
envsubst '$PORT' </etc/nginx/http.d/default.conf >/tmp/default.conf
cp /tmp/default.conf /etc/nginx/http.d/default.conf

# ── Laravel bootstrap ──────────────────────────
cd /var/www/html

# Generate app key if not set (first deploy)
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Fresh migration to reset duplicated data (one-time fix)
php artisan migrate:fresh --force

# Seed if no users exist yet (first deploy only)
USER_COUNT=$(php -r "require 'vendor/autoload.php'; \$app = require_once 'bootstrap/app.php'; \$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); echo \App\Models\User::count();" 2>/dev/null)
if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    echo "No users found — running db:seed..."
    php artisan db:seed --force
fi

# Clear & warm caches for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions one more time (Render may mount volumes)
chown -R www-data:www-data storage bootstrap/cache

# ── Start Supervisor (nginx + php-fpm) ─────────
exec /usr/bin/supervisord -c /etc/supervisord.conf
