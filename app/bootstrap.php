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

// Instance Router
$router = new \Bramus\Router\Router();

// Prepare Request Utilities
\App\Facades\RequestFacade::prepare($router->getRequestHeaders(), $router->getRequestMethod(), $_SERVER);

// Response Manager
$response = \App\Facades\ResponseFacade::prepare('application/json');

// Set Response Function
$showResponse = function (\App\Models\Communication\Model $optionalModel = null) use ($response) {
    echo $response::getResponse(function (\App\Models\Communication\Model $model) use ($optionalModel) {
        return json()::jsonEncode($optionalModel ?? $model);
    });
};

// Load Routes
$router = require_once __DIR__.'/../app/routes.php';

// Load Settings
$settings = require_once __DIR__.'/../app/settings.php';

// Store Settings
\App\Handlers\SettingsHandler::store($settings);

// Set 404 Route
$router->set404(function () use ($response, $showResponse) {
    $showResponse();
});

// Run Router
$router->run(function () use ($response, $showResponse) {
    $showResponse();
});
