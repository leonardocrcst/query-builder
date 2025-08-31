FROM php:8.4-alpine
RUN apk --no-cache update && \
    apk --no-cache upgrade && \
    apk --no-cache add \
        libzip-dev \
        libcurl \
        curl-dev \
        libpng \
        libpng-dev \
        libwebp \
        libwebp-dev \
        libjpeg-turbo \
        libjpeg-turbo-dev \
        autoconf \
        g++ \
        make \
        sqlite-dev \
        libxml2-dev \
        linux-headers \
        icu-dev \
        git \
        bash

RUN docker-php-ext-install curl gd pdo pdo_mysql pdo_sqlite simplexml zip intl

RUN pecl install xdebug pcov \
    && echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "extension=pcov.so" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.mode=debug,coverage" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.log=/var/www/logs/api/xdebug.log" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.discover_client_host=false" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "pcov.enabled=1" >> /usr/local/etc/php/conf.d/pcov.ini \
    && echo "date.timezone=America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini

RUN docker-php-ext-enable xdebug
RUN docker-php-ext-enable pcov

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer --no-dev --optimize-autoloader
RUN php -r "unlink('composer-setup.php');"

COPY config/start.sh /usr/local/bin/start
RUN chmod +x /usr/local/bin/start

WORKDIR /var/www
