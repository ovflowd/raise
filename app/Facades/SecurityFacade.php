<?php

namespace App\Facades;

use App\Models\Communication\TokenModel;

/**
 * Class SecurityFacade.
 */
class SecurityFacade
{
    /**
     * Get the JsonFacade Instance
     *
     * @return self
     */
    public static function get()
    {
        return __CLASS__;
    }

    /**
     * Inserts the client's token into the database.
     *
     * @param string $clientId
     *
     * @return string
     */
    public static function insertToken(string $clientId)
    {
        database()->insert('token',
            JsonFacade::map(new TokenModel(), ['clientId' => $clientId])->setExpireTime(),
            $token = self::generateToken());

        return json()::encode(setting('security.secretKey'), ['token' => $token]);
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
            response()::setResponse(403, "You didn't provided a Token");

            return false;
        }

        // Verifies if is an valid JWT
        if (($token = json()::decode(setting('security.secretKey'), $hash)) == false) {
            response()::setResponse(401, 'Your Token is Invalid or Expired');

            return false;
        }

        // Check if the Token exists on the Database and check if is Valid
        if (($token = database()->selectById('token', $token->token)) == false || $token->expireTime < microtime()) {
            response()::setResponse(401, 'Your Token is Invalid or Expired');

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
        $modelPath = ('App\Models\Communication\\' . ucfirst($modelName) . 'Model');

        return class_exists($modelPath) ? json()::compare(new $modelPath(), $body) : false;
    }
}
