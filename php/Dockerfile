FROM php:7.2-fpm

# For composer
RUN apt-get update && \
    apt-get install -y zlib1g-dev && \
    apt-get install -y vim && \
    docker-php-ext-install zip

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
  php -r "if (hash_file('SHA384', 'composer-setup.php') !== trim(file_get_contents('https://composer.github.io/installer.sig'))) { echo 'ERROR: Invalid installer signature'.PHP_EOL; unlink('composer-setup.php'); exit(1); }" && \
  php composer-setup.php && \
  php -r "unlink('composer-setup.php');" && \
  mv composer.phar /usr/local/bin/composer

# Set composer environment
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# Install laravel installer and composer optimize
RUN composer global require --quiet hirak/prestissimo:^0.3 && \
    composer config -g repos.packagist composer https://packagist.jp && \
    composer global require "laravel/installer"

# PHP's DB setting
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo_mysql pdo_pgsql

# Install Node.js
RUN apt-get update && \
    apt-get install -my wget gnupg
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
    apt-get update && \
    apt-get install -y nodejs

WORKDIR /src