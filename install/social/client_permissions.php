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
 * @var \Couchbase\Bucket $permission
 */

// Create Client Read Context Permission
$permission->insert(security()::generateHash(),
    json()::map(new \App\Models\Communication\Permission(),
        ['name' => 'client_read_context', 'description' => 'Read own Context.']));

// Create Client Write Context Permission
$permission->insert(security()::generateHash(),
    json()::map(new \App\Models\Communication\Permission(),
        ['name' => 'client_write_context', 'description' => 'Write on own Context.']));

// Create Client Read Global Permission
$permission->insert(security()::generateHash(),
    json()::map(new \App\Models\Communication\Permission(),
        ['name' => 'client_read_global', 'description' => 'Read on Global context.']));

// Create Client Write Global Permission
$permission->insert(security()::generateHash(),
    json()::map(new \App\Models\Communication\Permission(),
        ['name' => 'client_write_global', 'description' => 'Write on Global context.']));
