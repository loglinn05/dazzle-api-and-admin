# 1. Build frontend assets
FROM node:18-alpine AS frontend-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
ARG VITE_API_BASE_URL_ARG
ARG VITE_APP_NAME_ARG
ENV VITE_API_BASE_URL=$VITE_API_BASE_URL_ARG
ENV VITE_APP_NAME=$VITE_APP_NAME_ARG
RUN npm run build

# 2. Build Laravel app
FROM shinsenter/laravel:dev-php8.2-nginx AS builder
USER root
WORKDIR /var/www/html
COPY ./ /var/www/html
COPY --from=frontend-builder /app/public/build /var/www/html/public/build
RUN composer install --no-progress --no-dev --prefer-dist --no-cache && \
    mkdir -p /var/www/html/logs && touch /var/www/html/logs/access.log /var/www/html/logs/error.log

# 3. Building the API
FROM php:8.4-fpm-alpine AS api

WORKDIR /var/www/html

RUN docker-php-ext-install pdo_mysql bcmath

USER root

COPY --from=builder /var/www/html/app /var/www/html/app

COPY --from=builder /var/www/html/bootstrap /var/www/html/bootstrap

COPY --from=builder /var/www/html/public /var/www/html/public

COPY --from=builder /var/www/html/resources /var/www/html/resources

COPY --from=builder /var/www/html/routes /var/www/html/routes

COPY --from=builder /var/www/html/database /var/www/html/database

COPY --from=builder /var/www/html/config /var/www/html/config

COPY --from=builder /var/www/html/vendor /var/www/html/vendor

COPY --from=builder /var/www/html/run-app.sh /var/www/html/run-app.sh

COPY --from=builder /var/www/html/artisan /var/www/html/artisan

COPY --from=builder /var/www/html/php-fpm.conf /var/www/html/php-fpm.conf

COPY --from=builder /var/www/html/composer.json /var/www/html/composer.json
COPY --from=builder /var/www/html/composer.lock /var/www/html/composer.lock

RUN mkdir -p /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs && \
    chmod +x /var/www/html/run-app.sh && chown -R 1000:1000 /var/www/html

USER 1000

EXPOSE 9000

CMD ["/var/www/html/run-app.sh"]

# 4. Building the facade

FROM cgr.dev/chainguard/nginx AS admin

WORKDIR /var/www/html

USER root

COPY --chown=1000:1000 --from=builder /var/www/html/public /var/www/html
COPY --chown=1000:1000 --from=builder /var/www/html/nginx.conf /etc/nginx/nginx.conf
COPY --chown=1000:1000 --from=builder /var/www/html/logs /var/www/html/logs

USER 1000

EXPOSE 8080
