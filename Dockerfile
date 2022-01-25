FROM php:8.1

RUN apt-get update && apt-get install --no-install-recommends -y \
        wget \
        vim \
        git \
        unzip

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY ./.docker/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN mkdir -p /usr/src/app

COPY composer.json /usr/src/app

WORKDIR /usr/src/app

RUN composer install --no-interaction

CMD ["/bin/bash"]
