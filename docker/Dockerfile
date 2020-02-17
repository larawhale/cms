FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmagickwand-dev \
    libpng-dev \
    libzip-dev

RUN pecl install \
    imagick

RUN docker-php-ext-enable \
    imagick

RUN docker-php-ext-configure \
    gd --with-freetype --with-jpeg

RUN docker-php-ext-install \
    exif \
    -j$(nproc) gd \
    pdo \
    pdo_mysql \
    soap \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
