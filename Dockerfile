FROM php:8.1

RUN apt-get update && apt-get install --no-install-recommends -y \
        wget \
        vim \
        git \
        unzip

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN mkdir -p /app

COPY composer.* /app/

WORKDIR /app

RUN composer install --no-interaction

COPY . .

CMD ["/bin/bash"]
