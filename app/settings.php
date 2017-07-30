<?php

/**
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

return [

    /*
    |----------------------------------------------------------------------------
    | RAIse Settings Block                                                      |
    |----------------------------------------------------------------------------
    */

    'raise' => [
        'databaseType' => 'couchbase',
        'path'         => '',
    ],

    /*
    |----------------------------------------------------------------------------
    | Couchbase Settings Block                                                  |
    |----------------------------------------------------------------------------
    */

    'couchbase' => [
        'address'  => '127.0.0.1',
        'username' => 'couch',
        'password' => 'couchbase',
    ],

    /*
    |----------------------------------------------------------------------------
    | Security Settings Block                                                   |
    |----------------------------------------------------------------------------
    */

    'security' => [
        'expireTime' => '2hours',
        'secretKey'  => 'default-raise-secret-key',
        'debug'      => false,
    ],

    /*
    |----------------------------------------------------------------------------
    | Log Settings Block                                                        |
    |----------------------------------------------------------------------------
    */

    'log' => [

    ],
];
