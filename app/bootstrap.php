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
| Include Resources                                                         |
|----------------------------------------------------------------------------
*/

// Include Composer Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Register Accessor Functions
require_once __DIR__ . '/../app/accessory.php';

// Register the middleware Routes
require_once __DIR__ . '/../app/routes.php';

/*
|----------------------------------------------------------------------------
| Prepare Error Handle                                                      |
|----------------------------------------------------------------------------
*/

whoops()->pushHandler(new \Whoops\Handler\PrettyPageHandler());

whoops()->register();

/*
|----------------------------------------------------------------------------
| Prepare Request and Response utilities                                    |
|----------------------------------------------------------------------------
*/

// Prepare RequestFacade, gathering the sent Request (headers, method, etc)
request()::prepare($router()->getRequestHeaders(), $router()->getRequestMethod(), $_SERVER);

// Prepare ResponseFacade, applying the response schema
response()::prepare('application/json');

// Prepare the Blade Engine, applying custom directives
blade()::prepare();

/*
|----------------------------------------------------------------------------
| Store Settings                                                            |
|----------------------------------------------------------------------------
*/

// Gather Settings from configuration file and store it on SettingsHandler
\App\Handlers\Settings::store(require_once __DIR__ . '/../app/settings.php');

// Set the running Time Zone
date_default_timezone_set(setting('raise.timeZone'));

/*
|----------------------------------------------------------------------------
| Error Logging                                                             |
|----------------------------------------------------------------------------
*/

error_reporting(!\App\Handlers\Settings::get('security.debug') ?: (E_ALL ^ (E_NOTICE | E_WARNING)));

ini_set('display_errors', \App\Handlers\Settings::get('security.debug'));

/*
|----------------------------------------------------------------------------
| Run the Router                                                            |
|----------------------------------------------------------------------------
*/

// Set the Not Found Route and set a Callback
$router()->set404($response);

// Run the Route and set a Callback
$router()->run($response);
