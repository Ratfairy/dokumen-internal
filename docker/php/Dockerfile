# syntax=docker/dockerfile:1

FROM php:8.3-fpm-bookworm

# Memasang library sistem dan extension PHP yang dibutuhkan Laravel,
# MySQL, QR Code PNG, serta proses PDF.
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        libonig-dev \
        libicu-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        bcmath \
        intl \
        gd \
        zip \
        opcache \
        exif \
        pcntl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Mengambil Composer dari image resmi Composer.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Composer dependency dipasang lebih dahulu agar layer Docker
# dapat digunakan ulang ketika source code berubah.
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# Menyalin source code Laravel ke image.
COPY . .
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Menyiapkan autoload, Laravel package discovery,
# folder dokumen, dan permission Laravel.
RUN composer dump-autoload --optimize \
    && php artisan package:discover --ansi \
    && mkdir -p \
        storage/app/private/documents/original \
        storage/app/private/documents/final \
        storage/app/private/documents/temp \
    && chown -R www-data:www-data \
        storage \
        bootstrap/cache \
    && chmod -R ug+rwX \
        storage \
        bootstrap/cache

CMD ["php-fpm"]