#!/bin/sh

while [ wget -qO- couchbase:8091 &> /dev/null -ne 0 ]
do
    echo "Waiting Couchbase Start..."
    sleep 5
done

while [ ! -f /app/vendor/autoload.php ]
do
    echo "Waiting Composer..."
    sleep 5
done

php /app/install/install.php

php-fpm