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
 * @var $permission \Couchbase\Bucket
 */

// Create Service Read Context Permission
$permission->insert(\App\Facades\Security::generateHash(),
    \App\Facades\Json::map(new \App\Models\Communication\Permission(),
        ['name' => 'service_read_context', 'description' => 'Read own Context.']));

// Create Service Write Context Permission
$permission->insert(\App\Facades\Security::generateHash(),
    \App\Facades\Json::map(new \App\Models\Communication\Permission(),
        ['name' => 'service_write_context', 'description' => 'Write on own Context.']));

// Create Service Read Global Permission
$permission->insert(\App\Facades\Security::generateHash(),
    \App\Facades\Json::map(new \App\Models\Communication\Permission(),
        ['name' => 'service_read_global', 'description' => 'Read on Global context.']));

// Create Service Write Global Permission
$permission->insert(\App\Facades\Security::generateHash(),
    \App\Facades\Json::map(new \App\Models\Communication\Permission(),
        ['name' => 'service_write_global', 'description' => 'Write on Global context.']));
