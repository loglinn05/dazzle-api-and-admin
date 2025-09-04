#!/bin/sh

# Dynamically set APP_URL if it's available from Render
if [ -z "$APP_URL" ]; then
    if [ ! -z "$RENDER_EXTERNAL_URL" ]; then
        printf "🌐 APP_URL not set, using RENDER_EXTERNAL_URL \n"
        export APP_URL="$RENDER_EXTERNAL_URL"
    else
        printf "🌐 APP_URL not set, using localhost \n"
        export APP_URL="http://localhost:8000"
    fi
else
    printf "🌐 APP_URL is already set \n"
fi

printf "⚙️ Running Laravel setup commands... \n"
php artisan migrate --force
php artisan db:seed --force
php artisan optimize

printf "🚀 Starting PHP-FPM... \n"
exec php-fpm -F
