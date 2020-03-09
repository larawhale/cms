FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    fonts-liberation \
    gconf-service \
    libappindicator3-1 \
    libasound2 \
    libatk1.0-0 \
    libcairo2 \
    libcups2 \
    libfontconfig1 \
    libfreetype6-dev \
    libgdk-pixbuf2.0-0 \
    libgtk-3-0 \
    libjpeg62-turbo-dev \
    libmagickwand-dev \
    libnspr4 \
    libnss3 \
    libpango-1.0-0 \
    libpng-dev \
    libxss1 \
    libzip-dev \
    lsb-release \
    wget \
    xdg-utils

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

RUN wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb

RUN dpkg -i google-chrome-stable_current_amd64.deb; apt-get -fy install

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
