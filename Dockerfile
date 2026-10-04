FROM php:8.3-apache-bookworm AS php-base
RUN apt-get update && apt-get install -y --no-install-recommends \
    libonig-dev libpq-dev libsqlite3-dev libzip-dev libxml2-dev unzip \
    && docker-php-ext-install -j$(nproc) mbstring pdo_mysql pdo_pgsql pdo_sqlite zip bcmath opcache \
    && rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/html

FROM php-base AS dependencies
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist --optimize-autoloader

FROM node:24-bookworm-slim AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

FROM php-base AS runtime
ENV APP_ENV=production APP_DEBUG=false LOG_CHANNEL=stderr \
    DB_CONNECTION=sqlite DB_DATABASE=/var/www/html/storage/app/petcare.sqlite \
    QUEUE_CONNECTION=sync CACHE_STORE=file SESSION_DRIVER=file
COPY . .
COPY --from=dependencies /var/www/html/vendor ./vendor
COPY --from=assets /app/public/build ./public/build
COPY deployment/apache.conf /etc/apache2/sites-available/000-default.conf
COPY deployment/php.ini /usr/local/etc/php/conf.d/petcare.ini
COPY deployment/entrypoint.sh /usr/local/bin/petcare-entrypoint
RUN a2enmod rewrite \
    && sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && php artisan package:discover --ansi \
    && ln -s /var/www/html/storage/app/public public/storage \
    && chmod +x /usr/local/bin/petcare-entrypoint \
    && chown -R www-data:www-data storage bootstrap/cache public/assets/img-add-pro /var/run/apache2 /var/lock/apache2 /var/log/apache2
USER www-data
EXPOSE 8080
ENTRYPOINT ["petcare-entrypoint"]
CMD ["apache2-foreground"]
