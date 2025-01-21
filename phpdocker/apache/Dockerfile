FROM php:7.4-apache

# Instalar o bash
RUN apt-get update && apt-get install -y bash

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libzip-dev \
    libonig-dev \
    libldap2-dev \
    zip \
    git \
    unzip \
    && docker-php-ext-install \
    pdo_mysql \
    mysqli \
    mbstring \
    json \
    curl \
    gd \
    intl \
    zip \
    soap \
    bcmath \
    tokenizer \
    xml \
    exif \
    opcache \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap

# Habilitar o mod_rewrite
RUN a2enmod rewrite

 

