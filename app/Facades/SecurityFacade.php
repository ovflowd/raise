<?php

namespace App\Facades;

use App\Handlers\SettingsHandler;
use App\Managers\DatabaseManager;
use App\Managers\ResponseManager;
use App\Models\Communication\TokenModel;

/**
 * Class SecurityFacade.
 */
class SecurityFacade
{
    /**
     * Inserts the client's token into the database.
     *
     * @param string $clientId
     *
     * @return string
     */
    public static function insertToken(string $clientId)
    {
        DatabaseManager::insert('token',
            JsonFacade::map(new TokenModel(), ['clientId' => $clientId])->setExpireTime(),
            $token = self::generateToken());

        return JsonFacade::encode(SettingsHandler::get('security.secretKey'), ['token' => $token]);
    }

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
     * Update the Token (Revalidate).
     *
     * @param string $hash
     */
    public static function updateToken(string $hash)
    {
    }

    /**
     * Check if the Token is Valid.
     *
     * @param string|bool $hash (JWT Hash)
     *
     * @return bool
     */
    public static function validateToken($hash)
    {
        if ($hash === false) {
            ResponseManager::get()->setResponse(403, "You didn't provided a Token");

            return false;
        }

        // Verifies if is an valid JWT
        if (($token = JsonFacade::decode(SettingsHandler::get('security.secretKey'), $hash)) == false) {
            ResponseManager::get()->setResponse(401, 'Your Token is Invalid or Expired');

            return false;
        }

        // Check if the Token exists on the Database and check if is Valid
        if (($token = DatabaseManager::selectById('token', $token->token)) == false || $token->expireTime < microtime(true)) {
            ResponseManager::get()->setResponse(401, 'Your Token is Invalid or Expired');

            return false;
        }

        return true;
    }

    /**
     * Check if the Request Payload it's valid
     * If is return it Mapped in the given Model
     * If not, return a false boolean.
     *
     * @param string $modelName
     * @param object $body
     *
     * @return bool|object
     */
    public static function validateBody(string $modelName, $body)
    {
        $modelPath = ('App\Models\Communication\\'.ucfirst($modelName).'Model');

        return class_exists($modelPath) ? JsonFacade::compare(new $modelPath(), $body) : false;
    }
}
