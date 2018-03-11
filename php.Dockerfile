FROM php:7.2-fpm

COPY docker/php.ini /etc/php
COPY docker/php.ini /usr/local/etc/php/