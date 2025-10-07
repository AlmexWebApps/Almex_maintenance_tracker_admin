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

# Copy PHP-FPM pool configuration if needed
# NOTA: Comentamos esta línea porque www_configuration.ini no es un formato válido para www.conf
# COPY docker/php/www_configuration.ini /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html

# Set permissions for www-data user
RUN chown -R www-data:www-data /var/www/html

# Cambiar al usuario www-data
USER www-data

EXPOSE 9000

CMD ["php-fpm"]
