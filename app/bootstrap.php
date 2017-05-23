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
require_once __DIR__ . '/../vendor/autoload.php';

// Instance Router
$router = new \Bramus\Router\Router();

// Response Manager
$response = new \App\Managers\ResponseManager('application/json');

// Load Routes
$router = require_once __DIR__ . '/../app/routes.php';

// Load Settings
$settings = require_once __DIR__ . '/../app/settings.php';

// Store Settings
\App\Handlers\SettingsHandler::store($settings);

// Run Router
$router->run(function () use ($response) {
    echo $response->getResponse(function (\App\Models\Response\ResponseModel $model) {
        return \App\Facades\JsonFacade::encode($model);
    });
});
