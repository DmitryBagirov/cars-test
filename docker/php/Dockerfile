FROM php:8.1-fpm-alpine

ARG PHP_INI_NAME

RUN apk update

# postgresql
RUN set -ex && apk --no-cache add postgresql-dev
RUN docker-php-ext-install pdo_pgsql
RUN apk add --no-cache freetype-dev libjpeg-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# extension to read images metadata
RUN docker-php-ext-install exif

# install xdebug
RUN apk add --no-cache $PHPIZE_DEPS && pecl install xdebug && docker-php-ext-enable xdebug

# composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apk add imagemagick
RUN apk add imagemagick-dev

RUN apk add --update --no-cache autoconf g++ imagemagick-dev libtool make pcre-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apk del autoconf g++ libtool make pcre-dev

COPY $PHP_INI_NAME /usr/local/etc/php/conf.d/40-custom.ini

COPY run.sh /tmp

ENTRYPOINT ["/tmp/run.sh","php-fpm","-F"]
