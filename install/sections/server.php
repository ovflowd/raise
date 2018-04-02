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
 * @var array
 * @var string $memoryQuota
 */
echo writeText('[INFO]', '96;1') . 'Getting Information from the Cluster via API....' . PHP_EOL;

$serverInfo = communicateCouchbase('pools/default', $credentials)['body'];

$memoryQuota = $serverInfo->memoryQuota;

$indexMemoryQuota = $serverInfo->indexMemoryQuota;

echo writeText('[INFO]', '96;1') . "Your Cluster Data RAM size is: {$memoryQuota}MB." . PHP_EOL;

echo writeText('[INFO]', '96;1') . "Your Cluster Indexing RAM size is: {$indexMemoryQuota}MB." . PHP_EOL;
