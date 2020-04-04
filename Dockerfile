FROM php:7.4-cli

RUN apt-get update && apt-get install --no-install-recommends -y \
        wget \
        vim \
        git \
        unzip

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN mkdir -p /usr/src/app

COPY composer.json /usr/src/app

WORKDIR /usr/src/app

RUN composer install --no-interaction

CMD ["make"]
