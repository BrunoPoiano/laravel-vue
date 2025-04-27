#!/bin/bash

# Ensure storage directory permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Start Nginx
service nginx start

# Wait for database
until nc -z -v -w30 db 5432
do
  echo "Waiting for database connection..."
  sleep 5
done

# Run migrations
php artisan migrate --force

# Start PHP-FPM in foreground
php-fpm -F
