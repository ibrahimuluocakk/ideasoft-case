#!/bin/bash

# Composer install
composer install --no-interaction --no-dev --optimize-autoloader

# Wait for database to be ready
echo "Waiting for database to be ready..."
while ! nc -z db 3306; do
    sleep 0.1
done

# Run migrations and seeders
php artisan migrate:fresh --seed --force

# Start PHP-FPM
exec php-fpm
