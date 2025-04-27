#!/bin/bash

# Ensure storage directory permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Start Nginx
service nginx start

# Wait for database
until netcat -z -v -w30 db 5432
do
  echo "Waiting for database connection..."
  sleep 5
done

# Create the sessions table and run migrations
php artisan session:table
php artisan migrate --force

# Start the application
php artisan serve --host=0.0.0.0 --port=8000 & npm run dev -- --host 0.0.0.0
