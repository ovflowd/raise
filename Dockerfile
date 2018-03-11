FROM php:7.2-fpm

RUN mkdir -p /usr/app

WORKDIR /usr/app

ADD composer.json /usr/app
ADD index.php /usr/app
ADD vendor/ /usr/app
ADD resources/ /usr/app
ADD public/ /usr/app
ADD install/ /usr/app
ADD app/ /usr/app

RUN apt-get update \
    && apt install -y wget gnupg \
    && wget -O /etc/apt/sources.list.d/couchbase.list http://packages.couchbase.com/ubuntu/couchbase-ubuntu1404.list \
    && wget -O ~/couchbase.key http://packages.couchbase.com/ubuntu/couchbase.key \
    && apt-key add ~/couchbase.key \
    && apt update \
    && wget -O ~/libssl.deb http://ftp.us.debian.org/debian/pool/main/o/openssl/libssl1.0.0_1.0.1t-1+deb8u7_amd64.deb \
    && dpkg --install ~/libssl.deb \
    && apt install -y libssl1.0.0 libcouchbase2-libevent libcouchbase2-libevent libcouchbase2-core libcouchbase-dev libcouchbase2-bin build-essential \
    && apt install -y --no-install-recommends git zip

RUN pecl install pcs-1.3.3 \
    && docker-php-ext-enable pcs
RUN pecl install couchbase \
    && docker-php-ext-enable couchbase

RUN curl --silent --show-error https://getcomposer.org/installer | php

RUN php composer.phar install

CMD ["php", "install/install.php"]