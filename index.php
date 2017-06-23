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

/*
|----------------------------------------------------------------------------
| Disable Error Reporting                                                   |
|----------------------------------------------------------------------------
*/

error_reporting(E_ALL);

ini_set('display_errors', true);

/*
|----------------------------------------------------------------------------
| Create The Application                                                    |
|----------------------------------------------------------------------------
*/

$app = require __DIR__.'/app/bootstrap.php';
