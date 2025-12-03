FROM php:8.3-apache

# =========================
# 1) Install sistem deps + ekstensi PHP
# =========================
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
        gd \
        zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# =========================
# 2) Copy composer binary
# =========================
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# =========================
# 3) Set workdir & install dependency PHP
# =========================
WORKDIR /var/www/html

# Copy hanya file composer dulu, supaya layer cache efisien
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress

# =========================
# 4) Copy source code aplikasi
# =========================
COPY . .

# Pastikan folder storage dan cache ada & bisa ditulis
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# =========================
# 5) Set document root Laravel ke public/
# =========================
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
