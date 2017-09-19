FROM php:fpm

RUN docker-php-ext-install mbstring mysqli pdo_mysql