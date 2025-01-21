FROM phpdockerio/php:7.4-fpm

WORKDIR /L5_Networks

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        git \
        php7.4-dba \
        php7.4-http \
        php7.4-memcached \
        php7.4-mysql \
        php7.4-redis \
        php7.4-yaml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
