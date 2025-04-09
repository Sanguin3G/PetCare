# Start from the official PHP image with Apache or FPM
FROM php:8.2-fpm

# Install necessary PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable opcache
RUN docker-php-ext-install opcache

# Copy custom php.ini (if you have one)
# COPY ./php.ini /usr/local/etc/php/

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html
# Copy Laravel application files
COPY . .

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache


# Expose port
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]