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
 * @var $profiles \Couchbase\Bucket
 */

// Create Clients Group
$profiles->insert(\App\Facades\Security::generateHash(),
    \App\Facades\Json::map(new \App\Models\Communication\Profile(),
        [
            'name'        => 'Client',
            'uniqueName'  => 'client',
            'description' => 'The clients Group',
            'permissions' => [
                'client_read_context',
                'client_write_context',
                'service_read_context',
                'service_write_context',
                'data_read_context',
                'data_write_context',
            ],
        ]));
