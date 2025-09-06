#!/bin/sh

printf "⚙️ Running Laravel setup commands... \n"
php artisan migrate --force
php artisan db:seed --force
php artisan optimize

printf "🚀 Starting PHP-FPM... \n"
exec php-fpm -F
