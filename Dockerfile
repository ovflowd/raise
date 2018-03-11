FROM php:7.2-fpm

RUN mkdir -p /raise-core

WORKDIR /raise-core

CMD ["php", "install/install.php"]