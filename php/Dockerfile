FROM php:8.2.1-fpm-alpine3.17

# Setup
RUN apk update && \
    apk add zlib-dev && \
    apk add vim

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set composer environment
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# Install laravel installer
RUN composer global require "laravel/installer"

# PHP's DB setting
RUN docker-php-ext-install pdo_mysql

# Install Node.js
RUN apk add wget gnupg
RUN apk add --update npm

# Remove cache
RUN rm -rf /var/cache/apk/*

WORKDIR /src
