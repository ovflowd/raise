<?php

use App\Facades\RequestFacade;
use App\Facades\SecurityFacade;

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

$router->get('/', function () use ($response) {
    $response->setResponse(200, 'Welcome to RAISe');
});

/*
|----------------------------------------------------------------------------
| Client API Routes                                                         |
|----------------------------------------------------------------------------
*/

$router->mount('/client', function () use ($router) {
    // Client Security
    $router->before('GET', '/*', function () use ($router) {
        if (SecurityFacade::validateToken(RequestFacade::headers('authorization'))) {
            // List Clients
            $router->get('/', '\App\Controllers\ClientController@list');
        }
    });
    // Register a Client
    $router->post('/register', '\App\Controllers\ClientController@register');
});

/*
|----------------------------------------------------------------------------
| Service API Routes                                                        |
|----------------------------------------------------------------------------
*/

$router->mount('/service', function () use ($router) {
    // Service Security
    $router->before('GET|POST', '/*', function () use ($router) {
        if (SecurityFacade::validateToken(RequestFacade::headers('authorization'))) {
            // Register a Service
            $router->post('/register', '\App\Controllers\ServiceController@register');

            // List Service
            $router->get('/', '\App\Controllers\ServiceController@list');
        }
    });
});

/*
|----------------------------------------------------------------------------
| Data API Routes                                                           |
|----------------------------------------------------------------------------
*/

$router->mount('/data', function () use ($router) {
    // Data Security
    $router->before('GET|POST', '/*', function () use ($router) {
        if (SecurityFacade::validateToken(RequestFacade::headers('authorization'))) {
            // Register Data
            $router->post('/register', '\App\Controllers\DataController@register');

            // List Data
            $router->get('/', '\App\Controllers\DataController@list');
        }
    });
});

/*
|----------------------------------------------------------------------------
| Management API Routes                                                     |
|----------------------------------------------------------------------------
*/

// Todo

return $router;
