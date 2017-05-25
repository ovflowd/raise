<?php

namespace App\Facades;

use App\Managers\DatabaseManager;
use App\Managers\ResponseManager;
use App\Models\Communication\TokenModel;

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
        return bin2hex(openssl_random_pseudo_bytes(20));
    }

    /**
     * Inserts the client's token into the database.
     *
     * @param string $token
     * @param string $clientId
     */
    public static function insertToken(string $token, string $clientId)
    {
        $model = (new TokenModel())->fill(['serverTime' => time(), 'clientId' => $clientId]);

        $model->setExpireTime();

        DatabaseManager::getConnection()->insert('token', $model, $token);
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
     * @param string       $modelName
     * @param array|object $body
     *
     * @return bool
     */
    public static function validateBody(string $modelName, $body)
    {
        $className = ('App\Models\Communication\\'.ucfirst($modelName).'Model');

        if (class_exists($className)) {
            $model = new $className();

            $result = UtilitiesFacade::arrayDiff((array) $model, (array) $body);

            $result = UtilitiesFacade::arrayDiff(['serverTime'], array_values($result));

            return empty($result);
        }

        return false;
    }
}
