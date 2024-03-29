FROM alpine:3.17

RUN apk add --no-cache \
    coreutils \
    gettext \
    php81-fpm \
    php81-ctype \
    php81-curl \
    php81-dom \
    php81-gd \
    php81-iconv \
    php81-json \
    php81-intl \
    php81-fileinfo\
    php81-mbstring \
    php81-opcache \
    php81-openssl \
    php81-pdo \
    php81-pdo_mysql \
    php81-mysqli \
    php81-xml \
    php81-xsl \
    php81-zlib \
    php81-phar \
    php81-tokenizer \
    php81-session \
    php81-simplexml \
    php81-zip \
    php81-xmlwriter \
    php81-sodium \
    php81-pecl-apcu \
    make \
    curl

RUN apk update && apk add bash

RUN curl -sS https://getcomposer.org/installer | tee composer-setup.php \
    && php81 composer-setup.php && rm composer-setup.php* \
    && chmod +x composer.phar && mv composer.phar /usr/bin/composer \
    && ln -s /usr/bin/php81 /usr/local/bin/php

WORKDIR /var/www/html

CMD ["php-fpm81", "-F"]

EXPOSE 9001
