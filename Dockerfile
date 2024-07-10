FROM php:8.1-apache


RUN apt-get update \
    && apt-get install git libpq-dev libmcrypt-dev libzip-dev --yes

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install \
    mysqli \
    pgsql \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
