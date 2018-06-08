FROM php:7.2-fpm

WORKDIR /

ADD docker/libssl.deb .
ADD docker/couchbase.key .

RUN apt-get update && \
    apt-get install -y wget gnupg git zip apt-utils

RUN curl -sS "http://packages.couchbase.com/ubuntu/couchbase-ubuntu1404.list" > /etc/apt/sources.list.d/couchbase.list

RUN apt-key add couchbase.key
RUN dpkg --install libssl.deb

RUN apt-get update && \
    apt-get install -y zlib1g-dev libssl1.0.0 libcouchbase2-libevent libcouchbase2-libevent libcouchbase2-core libcouchbase-dev libcouchbase2-bin build-essential

WORKDIR /scripts

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install pcs-1.3.3 igbinary couchbase

RUN docker-php-ext-enable igbinary pcs couchbase
RUN echo "register_argc_argv = true" >> /usr/local/etc/php/php.ini

WORKDIR /app

EXPOSE 9000