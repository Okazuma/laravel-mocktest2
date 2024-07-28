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



# Cron のインストール
RUN apt-get update && apt-get install -y cron

# スケジュール設定ファイルを追加
COPY crontab /etc/cron.d/cronjob

# スケジュール設定ファイルのパーミッションを変更
RUN chmod 0644 /etc/cron.d/cronjob

# Cron サービスの起動スクリプトを追加
COPY cron-start.sh /usr/local/bin/cron-start.sh
RUN chmod +x /usr/local/bin/cron-start.sh

# エントリーポイントの設定
CMD ["/usr/local/bin/cron-start.sh"]