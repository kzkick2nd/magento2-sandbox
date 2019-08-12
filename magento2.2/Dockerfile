FROM php:7.0-apache

ARG MAGENTO_MARKET_USER
ARG MAGENTO_MARKET_PASS

RUN apt-get update \
    && apt-get install -y \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libxslt1-dev \
    mysql-client \
    unzip

RUN docker-php-ext-configure \
    gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install \
    dom \
    gd \
    intl \
    mbstring \
    mcrypt \
    pdo_mysql \
    xsl \
    zip \
    soap \
    bcmath

RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -q -- --install-dir=/usr/local/bin --filename=composer

RUN chown www-data:www-data /var/www

USER www-data
WORKDIR /var/www/html/

# TODO gzip に変えて ADD に変更
COPY ./Magento-CE-2.2.9-2019-06-13-01-58-36.zip ./
RUN unzip -q Magento-CE-2.2.9-2019-06-13-01-58-36.zip

RUN composer config -g http-basic.repo.magento.com $MAGENTO_MARKET_USER $MAGENTO_MARKET_PASS
RUN composer require sendgrid/email-delivery-simplified:1.0.3
