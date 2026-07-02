# https://hub.docker.com/_/php

FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
  libzip-dev \
  zip \
  unzip \
  sqlite3 \
  && docker-php-ext-install zip \
  && a2enmod rewrite \
  && rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT /app/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

