# Build Stage
ARG PHP_EXTS="bcmath ctype fileinfo mbstring pdo pdo_mysql dom pcntl"
FROM composer:2.6.5 as build
ARG PHP_EXTS

RUN mkdir -p /app
WORKDIR /app

RUN addgroup -S composer && adduser -S composer -G composer && chown -R composer /app
RUN apk add --virtual build-dependencies --no-cache ${PHPIZE_DEPS} openssl ca-certificates libxml2-dev oniguruma-dev \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTS} \
    && apk del build-dependencies

USER composer
COPY --chown=composer composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist
COPY --chown=composer . .
COPY --chown=composer .env.example .env
RUN composer install --no-dev --prefer-dist

# Final Production Stage
FROM php:8.1-fpm as server

ENV APP_NAME=Inventorx
ENV APP_ENV=production
ENV APP_DEBUG=true
ENV ACCESS_TOKEN_EXPIRATION=86400

ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=:memory:


WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    openssl \
    nginx \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    curl \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    locales \
    libonig-dev \
    lua-zlib-dev \
    libmemcached-dev \
    vim \
    supervisor \
    systemctl \
    net-tools \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN pecl install redis && docker-php-ext-install pdo_mysql mbstring zip exif pcntl sockets && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd && docker-php-ext-enable redis

# Copy files from build stage
COPY --chown=www-data:www-data --from=build /app /var/www

# Copy configuration files
COPY docker/supervisor/supervisor.conf /etc/supervisord.conf
COPY docker/php/app.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/nginx/app.conf /etc/nginx/sites-enabled/default

# Expose ports
EXPOSE 80 9000

# Start php and nginx
ENTRYPOINT ["sh", "./docker/entrypoint.sh"]
