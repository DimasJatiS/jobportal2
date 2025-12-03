# =========================
# Stage 1: Composer (build)
# =========================
FROM composer:2.6 AS build

WORKDIR /app

# Copy composer files dan install dependencies (tanpa dev)
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress

# =========================
# Stage 2: PHP + Apache
# =========================
FROM php:8.3-apache

# Install dependency sistem + ekstensi PHP (GD, ZIP, MySQL, PostgreSQL)
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        zip \
        gd \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy seluruh source code aplikasi
COPY . .

# Copy folder vendor dari stage build
COPY --from=build /app/vendor ./vendor
COPY --from=build /app/composer.json ./composer.json
COPY --from=build /app/composer.lock ./composer.lock

# Set document root Apache ke public Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
    && sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf

# Pastikan folder storage & cache ada dan bisa ditulis
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
