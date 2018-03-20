#!/bin/sh

wait_for_start() {
    "$@"
    while [ $? -ne 0 ]
    do
        sleep 3
        "$@"
    done
}

wait_for_start wget -q couchbase:8091

cd /app/

php install/install.php