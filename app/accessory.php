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

/**
 * Get the static instance of the LogFacade.
 *
 * @return \App\Facades\Facade|\App\Facades\Log|string
 */
function logger()
{
    return \App\Facades\Log::get();
}

/**
 * Get the Root System FS Path.
 *
 * @return string the current root path
 */
function root()
{
    return __DIR__.'/../';
}

/**
 * Get the Application or Sub Application FS Path.
 *
 * @param string $context the application sub directory
 *
 * @return bool|string return the context path if exists, if not return false
 */
function path(string $context = '')
{
    return is_dir(($path = root().$context)) ? $path : false;
}

/**
 * Get the static instance of ResponseFacade.
 *
 * @return \App\Facades\Facade|\App\Facades\Response|string
 */
function response()
{
    return \App\Facades\Response::get();
}

/**
 * Get the static instance of ViewFacade.
 *
 * @return \App\Facades\Facade|\App\Facades\View|string
 */
function view()
{
    return \App\Facades\View::get();
}

/**
 * Get the static instance of RequestFacade.
 *
 * @return \App\Facades\Facade|\App\Facades\Request|string
 */
function request()
{
    return \App\Facades\Request::get();
}

/**
 * Get the DatabaseHandler Instance based on DatabaseManager approach.
 *
 * @return \App\Database\Couchbase|\App\Models\Interfaces\Database
 */
function database()
{
    return \App\Managers\Database::getHandler();
}

/**
 * Get the static instance of JsonFacade.
 *
 * @return \App\Facades\Facade|\App\Facades\Json|string
 */
function json()
{
    return \App\Facades\Json::get();
}

/**
 * Get the static instance of SecurityFacade.
 *
 * @return \App\Facades\Facade|\App\Facades\Security|string
 */
function security()
{
    return \App\Facades\Security::get();
}

/**
 * Get a specific settings entry from the SettingsHandler.
 *
 * @param string $configuration A setting model name or a setting model name with a entry
 *
 * @return bool|mixed false if didn't found what you're searching,
 *                    If not return the value of the property or the model
 */
function setting(string $configuration)
{
    return \App\Handlers\Settings::get($configuration);
}

/**
 * Register the Whoops Error Handler.
 *
 * Also return the Whoops Handler Context
 *
 * @return \Whoops\Run Whoops Handler
 */
function whoops()
{
    static $whoops;

    if (null === $whoops) {
        $whoops = new Whoops\Run();
    }

    return $whoops;
}

/**
 * Get the Router instance.
 *
 * If the instance already exists return it, if not create it
 *
 * @return \Bramus\Router\Router
 */
$router = function () {
    static $router;

    return $router ?? ($router = new \Bramus\Router\Router());
};

/**
 * Output the jSON Response of the result of the execution of RAISe.
 *
 * You can also provide a specific Model, that will override the ResponseFacade's model.
 * This accessory function echoes the output and exit the application with success status
 *
 * @param \App\Models\Communication\Model|null $optionalModel An optional Model to override the response
 */
$response = function (\App\Models\Communication\Model $optionalModel = null) {
    switch (response()::type()) {
        case 'application/json':
            echo response()::response(function (\App\Models\Communication\Model $model) use ($optionalModel) {
                return json()::jsonEncode($optionalModel ?? $model);
            });
            break;
        case 'text/html':
            echo response()::content(function ($content) {
                return view()::render($content);
            });
            break;
    }

    exit(0);
};

/**
 * Does the token validation process.
 *
 * This accessory function checks if the token is valid, if is
 * store an instance of the TokenModel and return it.
 * If the token isn't valid, echoes the output of invalid authentication and finish the execution
 *
 * @param bool $exit If token doesn't exists and need to exit?
 *
 * @return \App\Models\Communication\Token
 */
$token = function (bool $exit = true) use ($response) {
    static $tokenModel;

    if ($tokenModel == null) {
        $tokenModel = security()::validateToken(request()::headers('authorization'));

        if ($tokenModel === false && $exit) {
            $response();

            exit(1);
        }
    }

    return $tokenModel;
};
