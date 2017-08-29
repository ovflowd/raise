<?php

/*
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

/** @var $connection CouchbaseCluster */
/** @var $memoryQuota string */
/** @var $buckets array */
/** @var $credentials array */
global $connection, $memoryQuota, $buckets, $credentials;

$buckets = [
    'metadata' => floor((($memoryQuota / 100) * 10)),
    'client' => floor((($memoryQuota / 100) * 10)),
    'service' => floor((($memoryQuota / 100) * 10)),
    'token' => floor((($memoryQuota / 100) * 10)),
    'data' => floor((($memoryQuota / 100) * 20)),
    'log' => floor((($memoryQuota / 100) * 10)),
    'permission' => floor((($memoryQuota / 100) * 5)),
    'profile' => floor((($memoryQuota / 100) * 5)),
    'relation' => floor((($memoryQuota / 100) * 10)),
];

echo writeText('INFO', '46') . 'Starting Creation Process...' . PHP_EOL;

echo progressBar(0, 9);

$progress = 1;

foreach ($buckets as $bucketName => $bucketMemory) {
    echo progressBar($progress++, 9, "Creating Bucket: {$bucketName}.              ");

    sleep(1);

    if (createBucket(['name' => $bucketName, 'memory' => $bucketMemory], $credentials) == false) {
        exit(1);
    }
}

echo progressBar(9, 9, 'Buckets Created Successfully.');