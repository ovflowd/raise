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
| Basic API Routes                                                          |
|----------------------------------------------------------------------------
*/

// Main Route
$router()->get('/', function () {
    response()::setResponse(200, 'Welcome to RAISe');
});

// Easter Egg
$router()->get('/tea', function () {
    response()::setResponse(408, 'RAISe easter egg');
});

/*
|----------------------------------------------------------------------------
| Client API Routes                                                         |
|----------------------------------------------------------------------------
*/

$router()->mount('/client', function () use ($router, $response, $token) {
    // Client Security
    $router()->before('GET', '/*', function () use ($router, $response, $token) {
        $token();
    });

    // List Clients
    $router()->get('/', '\App\Controllers\Client@list');

    // Register a Client
    $router()->post('/register', '\App\Controllers\Client@register');
});

/*
|----------------------------------------------------------------------------
| Service API Routes                                                        |
|----------------------------------------------------------------------------
*/

$router()->mount('/service', function () use ($router, $response, $token) {
    // Service Security
    $router()->before('GET|POST', '/*', function () use ($router, $response, $token) {
        $token();
    });

    // Register a Service
    $router()->post('/register', '\App\Controllers\Service@register');

    // List Service
    $router()->get('/', '\App\Controllers\Service@list');
});

/*
|----------------------------------------------------------------------------
| Data API Routes                                                           |
|----------------------------------------------------------------------------
*/

$router()->mount('/data', function () use ($router, $response, $token) {
    // Data Security
    $router()->before('GET|POST', '/*', function () use ($router, $response, $token) {
        $token();
    });

    // Register Data
    $router()->post('/register', '\App\Controllers\Data@register');

    // List Data
    $router()->get('/', '\App\Controllers\Data@list');
});

/*
|----------------------------------------------------------------------------
| Management API Routes                                                     |
|----------------------------------------------------------------------------
*/

// @TODO: Define the Management API Routes
