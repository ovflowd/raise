<?php

namespace App\Facades;

use App\Models\Communication\Model;
use App\Models\Communication\Token as TokenDefinition;

/**
 * Class SecurityFacade.
 */
class SecurityFacade extends Facade
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
        return json()::encode(setting('security.secretKey'), [
            'token' => database()->insert('token',
                json()::map(new TokenDefinition(), array('clientId' => $clientId)), self::generateToken()),
        ]);
    }

    /**
     * Generate a random pseudo string that will be used as token
     * the token will be always of 40 characters.
     *
     * @return string
     */
    protected static function generateToken()
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
     * @return bool|Token
     */
    public static function validateToken($hash)
    {
        // Verifies if the token is present on the headers
        if ($hash === false) {
            response()::setResponse(403, "You didn't provided a Token");

            return false;
        }

        // Verifies if is an valid JWT
        if (($token = json()::decode(setting('security.secretKey'), $hash)) == false) {
            response()::setResponse(401, 'Your Token is Invalid or Expired');

            return false;
        }

        // Retrieve the TokenModel if it exists on the database
        $tokenModel = database()->selectById('token', $token->token);

        // Check if the Token exists on the Database and check if is valid
        if ($tokenModel == false || $tokenModel->expireTime < microtime(true)) {
            response()::setResponse(401, 'Your Token is Invalid or Expired');

            return false;
        }

        return $tokenModel;
    }

    /**
     * Check if the Request Payload it's valid
     * If is return it Mapped in the given Model
     * If not, return a false boolean.
     *
     * @param string $modelName
     * @param object $body
     *
     * @return bool|object|Model
     */
    public static function validateBody(string $modelName, $body)
    {
        $modelPath = ('App\Models\Communication\\' . ucwords($modelName));

        return class_exists($modelPath) ? json()::compare(new $modelPath(), $body) : false;
    }
}
