# Stage 1: ambil composer binary
FROM composer:2.6 AS composer_stage

# Stage 2: web server + PHP
FROM php:8.3-apache

# Install dependency sistem + ekstensi PHP (PDO MySQL, ZIP, GD)
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Copy composer dari stage pertama
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# Set workdir
WORKDIR /var/www/html

# Copy semua kode aplikasi
COPY . .

# Install dependency PHP (tanpa dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set document root Apache ke public Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Permission untuk storage & cache
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

# Command default: jalankan Apache
CMD ["apache2-foreground"]
