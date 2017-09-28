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

echo writeText('[INFO]', '96;1').'Starting to Fill Buckets...'.PHP_EOL;

echo progressBar(0, 9);

echo progressBar(1, 9, 'Filling Metadata Bucket...                  ');

try {
    $metadataBucket = database()->getConnection()->openBucket('metadata');

    $metadataBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Metadata Bucket!'.PHP_EOL;
}

echo progressBar(2, 9, 'Filling Client Bucket...                  ');

try {
    $clientBucket = database()->getConnection()->openBucket('client');

    // Create Primary Indexes
    $clientBucket->manager()->createN1qlPrimaryIndex('', false, false);

    // Create Properties Identify Indexes
    $clientBucket->manager()->createN1qlIndex('index-name', ['name']);
    $clientBucket->manager()->createN1qlIndex('index-processor', ['processor']);
    $clientBucket->manager()->createN1qlIndex('index-channel', ['channel']);

    // Create Domain Identify Indexes
    $clientBucket->manager()->createN1qlIndex('index-tags', ['tags']);
    $clientBucket->manager()->createN1qlIndex('index-clientTime', ['clientTime']);
    $clientBucket->manager()->createN1qlIndex('index-clientTime-', ['-clientTime']);

    // Create Time Related Indexes
    $clientBucket->manager()->createN1qlIndex('index-tags-clientTime', ['tags', 'clientTime']);
    $clientBucket->manager()->createN1qlIndex('index-name-clientTime', ['name', 'clientTime']);
    $clientBucket->manager()->createN1qlIndex('index-processor-clientTime', ['processor', 'clientTime']);
    $clientBucket->manager()->createN1qlIndex('index-channel-clientTime', ['channel', 'clientTime']);

    // Create Inverse Time Related Indexes
    $clientBucket->manager()->createN1qlIndex('index-tags-clientTime-', ['tags', '-clientTime']);
    $clientBucket->manager()->createN1qlIndex('index-name-clientTime-', ['name', '-clientTime']);
    $clientBucket->manager()->createN1qlIndex('index-processor-clientTime-', ['processor', '-clientTime']);
    $clientBucket->manager()->createN1qlIndex('index-channel-clientTime-', ['channel', '-clientTime']);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Client Bucket!'.PHP_EOL;
}

echo progressBar(3, 9, 'Filling Service Bucket...                  ');

try {
    $serviceBucket = database()->getConnection()->openBucket('service');

    // Create Primary Indexes
    $serviceBucket->manager()->createN1qlPrimaryIndex('', false, false);

    // Create Properties Identify Indexes
    $serviceBucket->manager()->createN1qlIndex('index-name', ['name']);
    $serviceBucket->manager()->createN1qlIndex('index-clientId', ['clientId']);

    // Create Domain Identify Indexes
    $serviceBucket->manager()->createN1qlIndex('index-tags', ['tags']);
    $serviceBucket->manager()->createN1qlIndex('index-clientTime', ['clientTime']);
    $serviceBucket->manager()->createN1qlIndex('index-clientTime-', ['-clientTime']);

    // Create Time Related Indexes
    $serviceBucket->manager()->createN1qlIndex('index-tags-clientTime', ['tags', 'clientTime']);
    $serviceBucket->manager()->createN1qlIndex('index-name-clientTime', ['name', 'clientTime']);
    $serviceBucket->manager()->createN1qlIndex('index-clientId-clientTime', ['clientId', 'clientTime']);

    // Create Inverse Time Related Indexes
    $serviceBucket->manager()->createN1qlIndex('index-tags-clientTime-', ['tags', '-clientTime']);
    $serviceBucket->manager()->createN1qlIndex('index-name-clientTime-', ['name', '-clientTime']);
    $serviceBucket->manager()->createN1qlIndex('index-clientId-clientTime-', ['clientId', '-clientTime']);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Service Bucket!'.PHP_EOL;
}

echo progressBar(4, 9, 'Filling Token Bucket...                  ');

try {
    $tokenBucket = database()->getConnection()->openBucket('token');

    // Create Primary Indexes
    $tokenBucket->manager()->createN1qlPrimaryIndex('', false, false);

    // Create Properties Identify Indexes
    $tokenBucket->manager()->createN1qlIndex('index-clientId', ['clientId']);

    // Create Domain Identify Indexes
    $tokenBucket->manager()->createN1qlIndex('index-clientTime', ['clientTime']);
    $tokenBucket->manager()->createN1qlIndex('index-clientTime-', ['-clientTime']);

    // Create Time Related Indexes
    $tokenBucket->manager()->createN1qlIndex('index-clientId-clientTime', ['clientId', 'clientTime']);

    // Create Inverse Time Related Indexes
    $tokenBucket->manager()->createN1qlIndex('index-clientId-clientTime-', ['clientId', '-clientTime']);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Token Bucket!'.PHP_EOL;
}

echo progressBar(5, 9, 'Filling Data Bucket...                  ');

try {
    $dataBucket = database()->getConnection()->openBucket('data');

    // Create Primary Indexes
    $dataBucket->manager()->createN1qlPrimaryIndex('', false, false);

    $dataBucket->manager()->createN1qlIndex('index-clientId', ['clientId']);
    $dataBucket->manager()->createN1qlIndex('index-serviceId', ['serviceId']);
    $dataBucket->manager()->createN1qlIndex('index-parameters', ['parameters']);

    // Create Domain Identify Indexes
    $dataBucket->manager()->createN1qlIndex('index-tags', ['tags']);
    $dataBucket->manager()->createN1qlIndex('index-clientTime', ['clientTime']);
    $dataBucket->manager()->createN1qlIndex('index-clientTime-', ['-clientTime']);

    // Create Time Related Indexes
    $dataBucket->manager()->createN1qlIndex('index-clientId-clientTime', ['clientId', 'clientTime']);
    $dataBucket->manager()->createN1qlIndex('index-serviceId-clientTime', ['serviceId', 'clientTime']);
    $dataBucket->manager()->createN1qlIndex('index-parameters-clientTime', ['parameters', 'clientTime']);
    $dataBucket->manager()->createN1qlIndex('index-tags-clientTime', ['tags', 'clientTime']);

    // Create Inverse Time Related Indexes
    $dataBucket->manager()->createN1qlIndex('index-clientId-clientTime-', ['clientId', '-clientTime']);
    $dataBucket->manager()->createN1qlIndex('index-serviceId-clientTime-', ['serviceId', '-clientTime']);
    $dataBucket->manager()->createN1qlIndex('index-parameters-clientTime-', ['parameters', '-clientTime']);
    $dataBucket->manager()->createN1qlIndex('index-tags-clientTime-', ['tags', '-clientTime']);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Data Bucket!'.PHP_EOL;
}

echo progressBar(6, 9, 'Filling Log Bucket...                 ');

try {
    $responseBucket = database()->getConnection()->openBucket('log');

    // Create Primary Indexes
    $responseBucket->manager()->createN1qlPrimaryIndex('', false, false);

    // Create Domain Identify Indexes
    $responseBucket->manager()->createN1qlIndex('index-serverTime', ['serverTime']);
    $responseBucket->manager()->createN1qlIndex('index-serverTime-', ['-serverTime']);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Response Bucket!'.PHP_EOL;
}

echo progressBar(7, 9, 'Filling Permission Bucket...                 ');

try {
    $responseBucket = database()->getConnection()->openBucket('permission');

    // Create Primary Indexes
    $responseBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Response Bucket!'.PHP_EOL;
}

echo progressBar(8, 9, 'Filling Profile Bucket...                 ');

try {
    $responseBucket = database()->getConnection()->openBucket('profile');

    // Create Primary Indexes
    $responseBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Response Bucket!'.PHP_EOL;
}

echo progressBar(9, 9, 'Filling Relations Bucket...                 ');

try {
    $responseBucket = database()->getConnection()->openBucket('relation');

    // Create Primary Indexes
    $responseBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Response Bucket!'.PHP_EOL;
}

echo progressBar(9, 9, 'Buckets Filled.                            ');

echo PHP_EOL;
