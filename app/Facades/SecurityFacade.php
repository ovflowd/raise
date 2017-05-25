<?php

namespace App\Facades;

use App\Managers\DatabaseManager;
use App\Managers\ResponseManager;
use App\Models\Communication\RaiseModel;
use stdClass;

/**
 * Class SecurityFacade.
 */
class SecurityFacade
{
    /**
     * Generate a random pseudo string that will be used as token
     * the token will be always of 40 characters.
     *
     * @return string
     */
    public static function generateToken()
    {
        return openssl_random_pseudo_bytes(40);
    }

    /**
     * Check if the Token is Valid.
     *
     * @param string $httpMethod
     * @param string $token
     *
     * @return bool
     */
    public static function validateToken(string $httpMethod, string $token)
    {
        $token = $httpMethod == 'GET' ? RequestFacade::query('token') : RequestFacade::body('token');

        if ($token == false) {
            ResponseManager::get()->setResponse(401, 'No Token provided.');

            return false;
        }

        if (DatabaseManager::getConnection()->count('token', $token) == 0) {
            ResponseManager::get()->setResponse(401, 'Invalid Token provided.');

            return false;
        }

        return true;
    }

    /**
     * Check if the Given Parameters of the Body/Request are valid.
     *
     * @param string     $httpMethod
     * @param stdClass   $body
     * @param RaiseModel $model
     *
     * @return bool
     */
    public static function validateParams(string $httpMethod, stdClass $body, RaiseModel $model)
    {
        return false;
    }
}
