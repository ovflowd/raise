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

/**
 * @var $connection CouchbaseCluster
 */

echo writeText('INFO', '46') . 'Starting to Fill Buckets...' . PHP_EOL;

echo progressBar(0, 9);

echo progressBar(1, 9, 'Filling Metadata Bucket...                  ');

try {
    $metadataBucket = $connection->openBucket('metadata');

    $metadataBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Metadata Bucket!' . PHP_EOL;
}

echo progressBar(2, 9, 'Filling Client Bucket...                  ');

try {
    $clientBucket = $connection->openBucket('client');

    $clientBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Client Bucket!' . PHP_EOL;
}

echo progressBar(3, 9, 'Filling Service Bucket...                  ');

try {
    $serviceBucket = $connection->openBucket('service');

    $serviceBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Service Bucket!' . PHP_EOL;
}

echo progressBar(4, 9, 'Filling Token Bucket...                  ');

try {
    $tokenBucket = $connection->openBucket('token');

    $tokenBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Token Bucket!' . PHP_EOL;
}

echo progressBar(5, 9, 'Filling Data Bucket...                  ');

try {
    $dataBucket = $connection->openBucket('data');

    $dataBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Data Bucket!' . PHP_EOL;
}

echo progressBar(6, 9, 'Filling Log Bucket...                 ');

try {
    $responseBucket = $connection->openBucket('log');

    $responseBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Response Bucket!' . PHP_EOL;
}

echo progressBar(7, 9, 'Filling Permission Bucket...                 ');

try {
    $responseBucket = $connection->openBucket('permission');

    $responseBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Response Bucket!' . PHP_EOL;
}

echo progressBar(8, 9, 'Filling Profile Bucket...                 ');

try {
    $responseBucket = $connection->openBucket('profile');

    $responseBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Response Bucket!' . PHP_EOL;
}

echo progressBar(9, 9, 'Filling Relations Bucket...                 ');

try {
    $responseBucket = $connection->openBucket('relation');

    $responseBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Response Bucket!' . PHP_EOL;
}

echo progressBar(9, 9, 'Buckets Filled.                            ');

echo PHP_EOL;