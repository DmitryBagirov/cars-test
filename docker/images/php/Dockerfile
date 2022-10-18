FROM php:8.1-fpm-alpine

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
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD ./php.ini /usr/local/etc/php/conf.d/php.ini
ADD ./ci.php.ini /usr/local/etc/php/conf.d/ci.php.ini

WORKDIR /var/www/project

