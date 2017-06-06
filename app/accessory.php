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
 * Get the ResponseFacade Instance.
 *
 * @return \App\Facades\Facade|\App\Facades\ResponseFacade|string
 */
function response()
{
    return \App\Facades\ResponseFacade::get();
}

/**
 * Get the RequestFacade Instance.
 *
 * @return \App\Facades\Facade|\App\Facades\RequestFacade|string
 */
function request()
{
    return \App\Facades\RequestFacade::get();
}

/**
 * Get the DatabaseHandler Instance.
 *
 * @return \App\Handlers\CouchbaseHandler|\App\Models\Interfaces\Database
 */
function database()
{
    return \App\Managers\DatabaseManager::getConnection();
}

/**
 * Get the JsonFacade Instance.
 *
 * @return \App\Facades\Facade|\App\Facades\JsonFacade|string
 */
function json()
{
    return \App\Facades\JsonFacade::get();
}

/**
 * Get the SecurityFacade Instance.
 *
 * @return \App\Facades\Facade|\App\Facades\SecurityFacade|string
 */
function security()
{
    return \App\Facades\SecurityFacade::get();
}

/**
 * Get a Variable from the SettingsHandler.
 *
 * @param string $configuration
 *
 * @return bool|mixed
 */
function setting(string $configuration)
{
    return \App\Handlers\SettingsHandler::get($configuration);
}

/**
 * Get a Bramus\Router Instance
 *
 * @return \Bramus\Router\Router
 */
$router = function () {
    static $router;

    return $router ?? ($router = new \Bramus\Router\Router());
};

/**
 * Show the Rendered Response
 *
 * @param \App\Models\Communication\Model|null $optionalModel
 */
$response = function (\App\Models\Communication\Model $optionalModel = null) {
    echo response()::getResponse(function (\App\Models\Communication\Model $model) use ($optionalModel) {
        return json()::jsonEncode($optionalModel ?? $model);
    });

    exit(0);
};

/**
 * Do the Token Validation and if everything all right
 * Returns the TokenModel
 *
 * @return \App\Models\Communication\TokenModel
 */
$token = function () use ($response) {
    static $tokenModel;

    if ($tokenModel == null) {
        $tokenModel = security()::validateToken(request()::headers('authorization'));

        if ($tokenModel === false) {
            $response();

            exit(1);
        }
    }

    return $tokenModel;
};


