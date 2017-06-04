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
 * @return \App\Facades\ResponseFacade
 */
function response()
{
    return \App\Facades\ResponseFacade::get();
}

/**
 * Get the RequestFacade Instance.
 *
 * @return \App\Facades\RequestFacade
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
 * @return \App\Facades\JsonFacade
 */
function json()
{
    return \App\Facades\JsonFacade::get();
}

/**
 * Get the SecurityFacade Instance.
 *
 * @return \App\Facades\SecurityFacade
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
