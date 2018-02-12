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
    response()::message(200, 'Welcome to RAISe');
});

// Easter Egg
$router()->get('/tea', function () {
    response()::message(418, 'RAISe easter egg');
});

/*
|----------------------------------------------------------------------------
| Client API Routes                                                         |
|----------------------------------------------------------------------------
*/

$router()->mount('/client', function () use ($router, $response, $token) {
    // Client Security for List Clients
    $router()->before('GET', '/*', function () use ($router, $response, $token) {
        $token();
    });

    // List Clients
    $router()->get('/', '\App\Controllers\Client@list');

    // Register a Client
    $router()->post('/register', '\App\Controllers\Client@register');

    // Revalidate a Client
    $router()->post('/revalidate', '\App\Controllers\Client@revalidate');
});

/*
|----------------------------------------------------------------------------
| Service API Routes                                                        |
|----------------------------------------------------------------------------
*/

$router()->mount('/service', function () use ($router, $response, $token) {
    // Service Security for Register Services and List Services
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
    // Data Security for Register Data and List Data
    $router()->before('GET|POST', '/*', function () use ($router, $response, $token) {
        $token();
    });

    // Register Data
    $router()->post('/register', '\App\Controllers\Data@register');

    // List Data
    $router()->get('/', '\App\Controllers\Data@list');

    // List Data Values
    $router()->get('/values', '\App\Controllers\Data@values');
});

/*
|----------------------------------------------------------------------------
| Permission API Routes                                                     |
|----------------------------------------------------------------------------
*/

$router()->mount('/permissions', function () use ($router, $response, $token) {
    // Data Security for all Operations on Permissions
    $router()->before('GET|POST|PUT|DELETE', '/*', function () use ($router, $response, $token) {
        $token();
    });

    // Create a Permission
    $router()->post('/register', '\App\Controllers\Permissions@register');

    // List Permissions
    $router()->get('/', '\App\Controllers\Permissions@list');

    // Update a Permission
    $router()->put('/update', '\App\Controllers\Permissions@update');

    // Delete a Permission
    $router()->delete('/remove', '\App\Controllers\Permissions@remove');
});

/*
|----------------------------------------------------------------------------
| Relations API Routes                                                      |
|----------------------------------------------------------------------------
*/

$router()->mount('/relations', function () use ($router, $response, $token) {
    // Data Security for all Operations on Relations
    $router()->before('GET|POST|PUT|DELETE', '/*', function () use ($router, $response, $token) {
        $token();
    });

    // Create a Relation
    $router()->post('/register', '\App\Controllers\Relations@register');

    // List Relations
    $router()->get('/', '\App\Controllers\Relations@list');

    // Update a Relation
    $router()->put('/update', '\App\Controllers\Relations@update');

    // Delete a Relation
    $router()->delete('/remove', '\App\Controllers\Relations@remove');
});

/*
|----------------------------------------------------------------------------
| Management API Routes                                                     |
|----------------------------------------------------------------------------
*/

$router()->mount('/manage', function () use ($router, $response, $token) {
    // Login Page
    $router()->get('/', '\App\Controllers\Manage@login');

    // Configurations Page
    $router()->get('/config', '\App\Controllers\Manage@config');
});

/*
|----------------------------------------------------------------------------
| Metrics View Routes                                                       |
|----------------------------------------------------------------------------
*/

$router()->mount('/view', function () use ($router, $response, $token) {
    // Index Page
    $router()->get('/', '\App\Controllers\Metrics@welcome');

    // Search Route
    $router()->get('/search', '\App\Controllers\Metrics@search');

    // Show Dashboard
    $router()->get('/home', '\App\Controllers\Metrics@home');

    // Hook a Client
    $router()->get('/client/(\w+)', '\App\Controllers\Metrics@client');

    // Hook a Service Data
    $router()->get('/service/(\w+)', '\App\Controllers\Metrics@data');
});

/*
|----------------------------------------------------------------------------
| Prototype Routes                                                          |
|----------------------------------------------------------------------------
*/

$router()->get('/all-data', '\App\Controllers\Data@listAll');