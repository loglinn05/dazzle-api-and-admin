# 1. Building the app

FROM bitnami/laravel:12.0.3 AS builder

USER root

WORKDIR /app

COPY ./ /app

# Install Composer and NPM dependencies, mount cache
RUN --mount=type=cache,target=/app/.npm npm set cache /app/.npm && npm install && npm run build && \
    composer install --no-progress --no-dev --prefer-dist --no-cache

# 2. Building the API

FROM php:8.4-fpm-alpine AS api-and-admin

WORKDIR /app

RUN docker-php-ext-install pdo_mysql bcmath

USER root

COPY --from=builder /app/app /app/app

COPY --from=builder /app/bootstrap /app/bootstrap

COPY --from=builder /app/public /app/public

COPY --from=builder /app/resources /app/resources

COPY --from=builder /app/routes /app/routes

COPY --from=builder /app/database /app/database

COPY --from=builder /app/config /app/config

COPY --from=builder /app/vendor /app/vendor

COPY --from=builder /app/run-app.sh /app/run-app.sh

COPY --from=builder /app/artisan /app/artisan

COPY --from=builder /app/composer.json /app/composer.json
COPY --from=builder /app/composer.lock /app/composer.lock

RUN mkdir -p /app/storage/framework/cache \
    /app/storage/framework/sessions \
    /app/storage/framework/views \
    /app/storage/logs \
    /app/storage/app/public && \
    chmod +x /app/run-app.sh && chown -R 1000:1000 /app

USER 1000

EXPOSE 9000

CMD ["/app/run-app.sh"]

# 3. Building the facade

FROM cgr.dev/chainguard/nginx AS web

COPY --from=builder /app/public /app
