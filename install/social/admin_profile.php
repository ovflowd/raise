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

/** @var $profiles \Couchbase\Bucket */
global $profiles;

// Create Administrator Group
$profiles->insert(\App\Facades\Security::generateHash(),
    \App\Facades\Json::map(new \App\Models\Communication\Profile(),
        [
            'name'        => 'Administrator',
            'uniqueName'  => 'administrator',
            'description' => 'The Administrator Group',
            'permissions' => [
                'client_read_global',
                'client_write_global',
                'service_read_global',
                'service_write_global',
                'data_read_global',
                'data_write_global',
            ],
        ]));
