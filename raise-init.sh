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

php /app/install/install.php