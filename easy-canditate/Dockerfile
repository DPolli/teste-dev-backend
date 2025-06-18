FROM php:8.2-fpm-alpine

ARG PUID=1000
ARG PGID=1000

RUN apk update && \
    apk add --no-cache \
    bash \
    shadow \
    git \
    curl \
    zip \
    unzip \
    nodejs \
    npm \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    freetype-dev \
    icu-dev \
    libpng \
    jpeg \
    freetype \
    icu \
    mysql-client \
    autoconf \
    g++ \
    make \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql opcache bcmath exif pcntl gd intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del --no-cache \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    freetype-dev \
    icu-dev \
    shadow \
    autoconf \
    g++ \
    make \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/*

RUN deluser www-data \
    && addgroup -g ${PGID} www-data \
    && adduser -u ${PUID} -G www-data -s /bin/sh -D www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
