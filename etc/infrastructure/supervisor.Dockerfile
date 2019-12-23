FROM php:7.4.0-fpm-alpine
WORKDIR /app

RUN apk --update upgrade \
    && apk add --no-cache autoconf automake make gcc g++ icu-dev rabbitmq-c rabbitmq-c-dev supervisor \
    && pecl install amqp-1.9.4 \
    && pecl install apcu-5.1.18 \
    && pecl install xdebug-2.9.0 \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        opcache \
        intl \
        pdo_mysql \
    && docker-php-ext-enable \
        amqp \
        apcu \
        opcache

COPY php/ /usr/local/etc/php/
COPY supervisor/supervisord.conf /etc/supervisord.conf
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
