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

echo writeText('[INFO]', '96;1').'Filling Metadata Bucket with Codes.'.PHP_EOL;

$metadataJson = json_decode(file_get_contents(__DIR__.'/../metadata.json'));

$progress = 1;

echo progressBar(0, 60);

foreach ($metadataJson as $metadata) {
    insertMetadata($metadata);

    echo progressBar($progress++, 60);
}

echo progressBar(60, 60);
