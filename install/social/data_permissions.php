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

/** @var $permission \Couchbase\Bucket */
global $permission;

// Create Data Read Context Permission
$permission->insert(\App\Facades\Security::generateHash(),
    \App\Facades\Json::map(new \App\Models\Communication\Permission(),
        ['name' => 'data_read_context', 'description' => 'Read own Context.']));

// Create Data Write Context Permission
$permission->insert(\App\Facades\Security::generateHash(),
    \App\Facades\Json::map(new \App\Models\Communication\Permission(),
        ['name' => 'data_write_context', 'description' => 'Write on own Context.']));

// Create Data Read Global Permission
$permission->insert(\App\Facades\Security::generateHash(),
    \App\Facades\Json::map(new \App\Models\Communication\Permission(),
        ['name' => 'data_read_global', 'description' => 'Read on Global context.']));

// Create Data Write Global Permission
$permission->insert(\App\Facades\Security::generateHash(),
    \App\Facades\Json::map(new \App\Models\Communication\Permission(),
        ['name' => 'data_write_global', 'description' => 'Write on Global context.']));
