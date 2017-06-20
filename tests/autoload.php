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

// Disable Error Reporting
error_reporting(0);

// Register Composer Autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Register Accessor Functions
require_once __DIR__.'/../app/accessory.php';

// Register the middleware Routes
require_once __DIR__.'/../app/routes.php';

// Load Settings
$settings = require_once __DIR__ . '/../app/settings.php';