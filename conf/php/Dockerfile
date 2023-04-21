FROM php:7.4-fpm

WORKDIR /app

COPY app .

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN chown -R www-data:www-data .