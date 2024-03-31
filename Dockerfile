ARG PHP_EXTS="bcmath ctype fileinfo mbstring pdo pdo_mysql dom pcntl"
FROM composer:2.6.5 as build
ARG PHP_EXTS
# Create the working directory
RUN mkdir -p /app
# Set the working directory
WORKDIR /app
# We need to create a composer group and user, and create a home directory for it, so we keep the rest of our image safe,
# And not accidentally run malicious scripts
RUN addgroup -S composer \
    && adduser -S composer -G composer \
    && chown -R composer /app \
    && apk add --virtual build-dependencies --no-cache ${PHPIZE_DEPS} openssl ca-certificates libxml2-dev oniguruma-dev \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTS} \
    && apk del build-dependencies
# Switch over to the composer user before running installs.
USER composer
# Copy in our dependency files.
COPY --chown=composer composer.json composer.lock ./
# Install all the dependencies without running any installation scripts.
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist
# Copy in our actual source code so we can run the installation scripts we need
COPY --chown=composer . .
# Copy .env
COPY --chown=composer .env.example .env
# Now that the code base and packages are all available,
# we can run the install again, and let it run any install scripts.
RUN composer install --no-dev --prefer-dist
# For running things like migrations, and queue jobs,
# we need a CLI container.
# It contains all the Composer packages,
# and just the basic CLI "stuff" in order for us to run commands,
# be that queues, migrations, tinker etc.
FROM php:8.2-fpm as server
# Set env and debug ready for production
ENV APP_NAME=Washbook
# ENV APP_URL='http:127.0.0.1:80'
ENV APP_KEY='base64:LsPVrOjJwn84sLuXQDbay5os4JIaZ34kSRz83KRn990='
ENV APP_ENV=development
ENV APP_DEBUG=true
ENV MAIL_MAILER=smtp
#ENV MAIL_HOST=
#ENV MAIL_PORT=
#ENV MAIL_USERNAME=
#ENV MAIL_FROM_ADDRESS=
#ENV MAIL_PASSWORD=
#ENV MAIL_ENCRYPTION=
#ENV MAIL_FROM_NAME=InventorX
ENV QUEUE_CONNECTION=sync
ENV PAGINATOR_LENGTH=20
ENV ACCESS_TOKEN_EXPIRATION=86400
ENV DB_CONNECTION=sqlite
#ENV FRONT_END_URL=''

# We need to declare that we want to use the args in this build step
ARG PHP_EXTS
WORKDIR /var/www
# We need to install some requirements into our image,
# used to compile our PHP extensions, as well as install all the extensions themselves.
# You can see a list of required extensions for Laravel here: https://laravel.com/docs/8.x/deployment#server-requirements
RUN apt-get update && apt-get install -y --no-install-recommends \
    openssl \
    nginx \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    zlib1g-dev \
    libzip-dev \
    locales \
    libonig-dev \
    lua-zlib-dev \
    libmemcached-dev \
    systemctl \
    net-tools
# Install supervisor
RUN apt-get install -y supervisor
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Install extensions for php
#RUN pecl install redis
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl #sockets
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
#RUN docker-php-ext-enable redis

COPY --chown=www-data:www-data --from=build /app /var/www

# Copy nginx/php/supervisor configs
RUN cp docker/supervisor/supervisor.conf /etc/supervisord.conf
RUN cp docker/php/app.ini /usr/local/etc/php/conf.d/app.ini
RUN cp docker/nginx/app.conf /etc/nginx/sites-enabled/default
# As FPM uses the www-data user when running our application,
# we need to make sure that we also use that user when starting up,
# so our user "owns" the application when running
#USER  www-app

# Expose ports
EXPOSE 80 9000

# Start php and nginx
ENTRYPOINT ["sh", "./docker/entrypoint.sh"]

