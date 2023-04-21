FROM composer:2.5 AS build

WORKDIR /app

COPY app/composer.json .

RUN composer install --no-dev --no-scripts

COPY app .

RUN composer dumpautoload --optimize

FROM php:8.1-fpm-alpine

WORKDIR /app

COPY --from=build /app .

COPY app .

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN chown -R www-data:www-data .