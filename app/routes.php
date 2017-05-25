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

$router->get('/', function () use ($response) {
    $response->setResponse(200, 'Welcome to RAISe');
});

/*
|----------------------------------------------------------------------------
| Client API Routes                                                         |
|----------------------------------------------------------------------------
*/

$router->mount('/client', function () use ($router) {
    // Client List Security
    $router->before('GET', '/*', function () {
        //\App\Facades\SecurityFacade::validateToken(\App\Facades\RequestFacade::method(), \App\Facades\RequestFacade::query('token'));
    });

    // Register a Client
    $router->post('/register', 'ClientController@register');

    // List Clients
    $router->get('/', 'ClientController@list');
});

/*
|----------------------------------------------------------------------------
| Service API Routes                                                        |
|----------------------------------------------------------------------------
*/

$router->mount('/service', function () use ($router) {
    // Service List Security
    $router->before('GET', '/*', function () use ($router) {
        //\App\Facades\SecurityFacade::validateToken($router->getRequestMethod(), \App\Facades\RequestFacade::query('token'));
    });

    // Service Register Security
    $router->before('POST', '/*', function () use ($router) {
        //\App\Facades\SecurityFacade::validateToken($router->getRequestMethod(), \App\Facades\RequestFacade::body('token'));
    });

    // Register a Service
    $router->post('/register', 'ServiceController@register');

    // List Service
    $router->get('/', 'ServiceController@list');
});

/*
|----------------------------------------------------------------------------
| Data API Routes                                                           |
|----------------------------------------------------------------------------
*/

$router->mount('/data', function () use ($router) {
    // Data List Security
    $router->before('GET', '/*', function () use ($router) {
        //\App\Facades\SecurityFacade::validateToken($router->getRequestMethod(), \App\Facades\RequestFacade::query('token'));
    });

    // Data Register Security
    $router->before('POST', '/*', function () use ($router) {
        //\App\Facades\SecurityFacade::validateToken($router->getRequestMethod(), \App\Facades\RequestFacade::body('token'));
    });

    // Register Data
    $router->post('/register', 'DataController@register');

    // List Data
    $router->get('/', 'DataController@list');
});

/*
|----------------------------------------------------------------------------
| Management API Routes                                                     |
|----------------------------------------------------------------------------
*/

// Todo

return $router;
