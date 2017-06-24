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

namespace App\Facades;

use App\Models\Communication\Client as ClientDefinition;
use App\Models\Communication\Model;
use App\Models\Communication\Token as TokenDefinition;

/**
 * Class Security.
 *
 * A Facade to handle all the Security and Authentication of RAISe
 *
 * @property ClientDefinition
 *
 * @see TokenDefinition
 * @see https://en.wikipedia.org/wiki/Facade_pattern Documentation of the Pattern
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Security extends Facade
{
    /**
     * Inserts the client's token into the database.
     *
     * @see Json JsonFacade
     * @see ClientDefinition
     *
     * @param string $clientId the given Client Identifier
     *
     * @return string the JWT Generated Hash
     */
    public static function insertToken(string $clientId)
    {
        $token = database()->insert('token', ($tokenModel = json()::map(new TokenDefinition(),
            ['clientId' => $clientId])), self::generateToken());

        logger()::log($token, 'token', "a token was generated on raise. (clientId:: {$clientId}).", $tokenModel);

        return json()::encode(setting('security.secretKey'), ['token' => $token]);
    }

    /**
     * Generate a random pseudo string that will be used as token
     * the token will be always of 40 characters.
     *
     * @see http://php.net/manual/en/function.openssl-random-pseudo-bytes.php OpenSSL Bytes Generator
     * @see bin2hex()
     *
     * @return string the generated openssl bytes encoded into a string
     */
    protected static function generateToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(20));
    }

    /**
     * Update the Token (Revalidate).
     *
     * Creates a new Token and Hash for the same
     * Client, when the Token is Invalid
     *
     * @param string $hash the Hash to be Validated
     *
     * @return array|null The JWT hash if the Token has expired and exists.
     */
    public static function updateToken(string $hash)
    {
        global $response;

        // Verifies if is an valid JWT
        if (($token = json()::decode(setting('security.secretKey'), $hash)) == false) {
           $response(response()::message(401, 'Your Token is Invalid or Expired', true));
        }

        // Retrieve the TokenModel if it exists on the database
        $tokenModel = database()->selectById('token', $token->token);

        // Check if the Token exists on the Database and check if is valid
        if ($tokenModel == false || $tokenModel->expireTime > microtime(true)) {
            $response(response()::message(401, 'Your Token is Invalid or not Expired', true));
        }

        database()->delete('token', $token->token);

        return ['jwtHash' => self::insertToken($tokenModel->clientId), 'clientId' => $tokenModel->clientId];
    }

    /**
     * Check if the Token is Valid.
     *
     * @see TokenDefinition
     *
     * @param string|bool $hash the Request Given JWT hash
     *
     * @return bool|TokenDefinition false if isn't valid the token or expired, a TokenModel if it's valid
     */
    public static function validateToken($hash)
    {
        // Verifies if the token is present on the headers
        if ($hash === false) {
            response()::message(403, "You didn't provided a Token");

            return false;
        }

        // Verifies if is an valid JWT
        if (($token = json()::decode(setting('security.secretKey'), $hash)) == false) {
            response()::message(401, 'Your Token is Invalid or Expired');

            return false;
        }

        // Retrieve the TokenModel if it exists on the database
        $tokenModel = database()->selectById('token', $token->token);

        // Check if the Token exists on the Database and check if is valid
        if ($tokenModel == false || $tokenModel->expireTime < microtime(true)) {
            response()::message(401, 'Your Token is Invalid or Expired');

            return false;
        }

        return $tokenModel;
    }

    /**
     * Check if the Request Payload it's valid
     * If is return it Mapped in the given Model
     * If not, return a false boolean.
     *
     * @param string $modelName the Model to be validated
     * @param object $body the Payload to be validated
     *
     * @return bool|object|Model the mapped model or false if doesn't exists
     */
    public static function validateBody(string $modelName, $body)
    {
        $model = ('App\Models\Communication\\' . ucwords($modelName));

        return class_exists($model) ? json()::compare($model, $body) : false;
    }
}
