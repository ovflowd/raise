FROM php:7.2

RUN echo "Installing Lib Couchbase Dependencies" \
    && apt update \
    && apt install -y wget gnupg \
    && wget -O /etc/apt/sources.list.d/couchbase.list http://packages.couchbase.com/ubuntu/couchbase-ubuntu1404.list \
    && wget -O ~/couchbase.key http://packages.couchbase.com/ubuntu/couchbase.key \
    && apt-key add ~/couchbase.key \
    && apt update \
    && wget -O ~/libssl.deb http://ftp.us.debian.org/debian/pool/main/o/openssl/libssl1.0.0_1.0.1t-1+deb8u7_amd64.deb \
    && dpkg --install ~/libssl.deb \
    && apt install -y libssl1.0.0 libcouchbase2-libevent libcouchbase2-libevent libcouchbase2-core libcouchbase-dev libcouchbase2-bin build-essential

RUN echo "Installing PCS Extension" \
    && pecl install pcs-1.3.3 \
    && docker-php-ext-enable pcs

RUN echo "Installing Couchbase Extension" \
    && pecl install couchbase \
    && docker-php-ext-enable couchbase

RUN echo "Read te Documentation of RAISe in order to configure RAISe here: goo.gl/9ukom5"