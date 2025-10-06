FROM php:8.2-fpm

# Install system dependencies and PHP extensions required by Laravel
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        curl \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql zip bcmath pcntl gd exif opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Copy Composer from the official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy PHP config
COPY docker/nginx/php_ini_settings.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/php/www_configuration.ini /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html

# Copy composer files first (for better caching)
COPY composer.json composer.lock ./

# Install dependencies (this layer will be cached)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy application files
COPY . .

# Generate optimized autoload
RUN composer dump-autoload --optimize

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache
