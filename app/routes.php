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

/*
|----------------------------------------------------------------------------
| Basic API Routes                                                          |
|----------------------------------------------------------------------------
*/

$router()->get('/', function () {
    response()::setResponse(200, 'Welcome to RAISe');
});

/*
|----------------------------------------------------------------------------
| Client API Routes                                                         |
|----------------------------------------------------------------------------
*/

$router()->mount('/client', function () use ($router, $showResponse) {
    // Client Security
    $router()->before('GET', '/*', function () use ($router, $showResponse) {
        if (security()::validateToken(request()::headers('authorization')) == false) {
            die($showResponse());
        }
    });

    // List Clients
    $router()->get('/', '\App\Controllers\ClientController@list');

    // Register a Client
    $router()->post('/register', '\App\Controllers\ClientController@register');
});

/*
|----------------------------------------------------------------------------
| Service API Routes                                                        |
|----------------------------------------------------------------------------
*/

$router()->mount('/service', function () use ($router, $showResponse) {
    // Service Security
    $router()->before('GET|POST', '/*', function () use ($router, $showResponse) {
        if (security()::validateToken(request()::headers('authorization')) == false) {
            die($showResponse());
        }
    });

    // Register a Service
    $router()->post('/register', '\App\Controllers\ServiceController@register');

    // List Service
    $router()->get('/', '\App\Controllers\ServiceController@list');
});

/*
|----------------------------------------------------------------------------
| Data API Routes                                                           |
|----------------------------------------------------------------------------
*/

$router()->mount('/data', function () use ($router, $showResponse) {
    // Data Security
    $router()->before('GET|POST', '/*', function () use ($router, $showResponse) {
        if (security()::validateToken(request()::headers('authorization')) == false) {
            die($showResponse());
        }
    });

    // Register Data
    $router()->post('/register', '\App\Controllers\DataController@register');

    // List Data
    $router()->get('/', '\App\Controllers\DataController@list');
});

/*
|----------------------------------------------------------------------------
| Management API Routes                                                     |
|----------------------------------------------------------------------------
*/

// Todo
