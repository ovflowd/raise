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

// Require Composer Autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Accessory Functions
require_once __DIR__.'/../app/accessory.php';

// Load Routes
require_once __DIR__.'/../app/routes.php';

// Response Manager
response()::prepare('application/json');

// Prepare Request Utilities
request()::prepare($router()->getRequestHeaders(), $router()->getRequestMethod(), $_SERVER);

// Load Settings
$settings = require_once __DIR__.'/../app/settings.php';

// Store Settings
\App\Handlers\SettingsHandler::store($settings);

// Set 404 Route
$router()->set404($showResponse);

// Run Router
$router()->run($showResponse);
