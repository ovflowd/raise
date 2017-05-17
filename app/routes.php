<?php

/*
 *                   .-'''-.
 *                  '   _    \
 *           .--. /   /` '.   \
 *           |__|.   |     \  '
 *           .--.|   '      |  '  .|
 *           |  |\    \     / / .' |_
 *    _    _ |  | `.   ` ..' /.'     |
 *   | '  / ||  |    '-...-'`'--.  .-'
 *  .' | .' ||  |               |  |
 *  /  | /  ||__|               |  |
 * |   `'.  |      UIoT RAISe   |  '.'
 * '   .'|  '/        alpha     |   /
 *  `-'  `--'                   `'-'
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

$router->get('/', function () {
    return 'Welcome to RAISe';
});

/*
|----------------------------------------------------------------------------
| Client API Routes                                                         |
|----------------------------------------------------------------------------
*/

// Register a Client
$router->post('/client/register', 'ClientController@register');

// List Clients
$router->get('/client', 'ClientController@list');

/*
|----------------------------------------------------------------------------
| Service API Routes                                                        |
|----------------------------------------------------------------------------
*/

// Register a Service
$router->post('/service/register', 'ServiceController@register');

// List Service
$router->get('/service', 'ServiceController@list');

/*
|----------------------------------------------------------------------------
| Data API Routes                                                           |
|----------------------------------------------------------------------------
*/

// Register Data
$router->post('/data/register', 'DataController@register');

// List Data
$router->get('/data', 'DataController@list');

/*
|----------------------------------------------------------------------------
| Management API Routes                                                     |
|----------------------------------------------------------------------------
*/

// Todo

return $router;
