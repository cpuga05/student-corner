FROM php:7.4.0-fpm-alpine
WORKDIR /app

RUN apk --update upgrade
RUN apk add --no-cache autoconf automake make gcc g++ icu-dev rabbitmq-c rabbitmq-c-dev
RUN pecl install amqp-1.9.4
RUN pecl install apcu-5.1.18
RUN pecl install xdebug-2.9.0
RUN docker-php-ext-install -j$(nproc) \
    bcmath \
    opcache \
    intl \
    pdo_mysql
RUN docker-php-ext-enable \
    amqp \
    apcu \
    opcache

COPY php/ /usr/local/etc/php/
