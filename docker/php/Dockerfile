FROM php:8.0-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

# Imagickのインストールを追加
RUN apt-get update \
    && apt-get install -y \
    libmagickwand-dev imagemagick \
    && pecl install imagick \
    && docker-php-ext-enable imagick

RUN docker-php-ext-install gd pdo pdo_mysql

WORKDIR /var/www