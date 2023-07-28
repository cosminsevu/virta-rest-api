#!/bin/bash

# Wait for MySQL container to be ready
/usr/local/bin/wait-for-it.sh laravel_mysql:3306 -t 60

# Run migrations
cd /var/www/html

# Run migrations
php artisan migrate

# Apply swagger:generate to Genarate API Documentation
php artisan l5-swagger:generate

# Run tests
php artisan test

# Start the Laravel development server
php artisan serve --host=0.0.0.0 --port=8080