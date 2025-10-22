#!/bin/bash
set -e

echo "=== Starting Application Setup ==="

echo "Waiting for database..."
sleep 30

if [ ! -f .env ]; then
    echo "Creating .env from .env.example"
    cp .env.example .env
fi

if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating APP_KEY..."
    php artisan key:generate
fi

echo "Running migrations..."
php artisan migrate

echo "Seeding database..."
php artisan db:seed

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Application Setup Complete ==="

mkdir -p /var/log/supervisor
mkdir -p /var/run/supervisor

echo "Starting PHP-FPM and Nginx..."
exec supervisord -c /etc/supervisor/conf.d/supervisor.conf