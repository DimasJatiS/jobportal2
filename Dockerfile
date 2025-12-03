# Stage 1: ambil binary composer
FROM composer:2.6 AS composer_stage

# Stage 2: web server + PHP
FROM php:8.3-apache

# Install dependency sistem + ekstensi yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Copy composer dari stage pertama
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# Set workdir
WORKDIR /var/www/html

# Copy semua kode aplikasi ke dalam image
COPY . .

# Install dependency PHP (tanpa dev)
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-suggest

# Atur document root ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Permission untuk storage & cache
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
