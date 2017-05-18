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
| Require Compose Autoloader                                                |
|----------------------------------------------------------------------------
*/

require_once __DIR__.'/../vendor/autoload.php';

// Instance Router
$router = new \Bramus\Router\Router();

// Gather Router Data
$router = require_once __DIR__.'/../app/routes.php';

// Run Router
$router->run();

$settings = require_once __DIR__.'/../app/settings.php';

\App\Handlers\SettingsHandler::store($settings);
