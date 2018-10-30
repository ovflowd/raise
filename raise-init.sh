#!/bin/sh

wait_for_start() {
    "$@"
    while [ $? -ne 0 ]
    do
        echo 'Waiting for Couchbase to start'
        sleep 3
        "$@"
    done
}

wait_for_start wget -qO- couchbase:8091 &> /dev/null

if [ ! -f /app/install/install.lock ]; then
   echo "Installing Composer Dependencies"

   composer install --no-dev --optimize-autoloader

   echo "Running RAISe Installer.."

   php /app/install/install.php
fi

php-fpm