#!/bin/sh

export $(cat /.env | grep -v ^# | xargs)

wait_for_start() {
    "$@"
    while [ $? -ne 0 ]
    do
        sleep 3
        "$@"
    done
}

/entrypoint.sh couchbase-server &

wait_for_start wget -q localhost:8091

couchbase-cli cluster-init -c localhost:8091 --cluster-username=${COUCHBASE_USERNAME} \
    --cluster-password=${COUCHBASE_PASSWORD} --cluster-name='raise' --services=data,index,query \
    --cluster-ramsize=${COUCHBASE_BASE_RAM} --cluster-index-ramsize=${COUCHBASE_INDEX_RAM}