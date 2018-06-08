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
use Koine\QueryBuilder\Statements\Select;

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
     * Update the Token (Revalidate).
     *
     * Creates a new Token and Hash for the same
     * Client, when the Token is Invalid
     *
     * @param string $hash the Hash to be Validated
     *
     * @return array|null The JWT hash if the Token has expired and exists.
     * @throws \Mapper\ModelMapperException
     */
    public static function updateToken(string $hash)
    {
        global $response;

        // Verifies if is an valid JWT
        if (($token = json()::decode(setting('security.secretKey'), $hash)) == false) {
            $response(response()::message(401, 'Your Token is Invalid or Expired', true));
        }

        // Retrieve the TokenModel if it exists on the database
        $tokenModel = database()->select('token', $token->token);

        // Check if the Token exists on the Database and check if is valid
        if ($tokenModel == false || $tokenModel->expireTime > microtime(true)) {
            $response(response()::message(401, 'Your Token is Invalid or not Expired', true));
        }

        database()->delete('token', $token->token);

        return [
            'jwtHash' => self::insertToken($tokenModel->clientId, $tokenModel->groupId),
            'clientId' => $tokenModel->clientId
        ];
    }

    /**
     * Inserts the client's token into the database.
     *
     * @see Json JsonFacade
     * @see ClientDefinition
     *
     * @param string $clientId the given Client Identifier
     * @param string $group the group that the Token will belong
     *
     * @return string the JWT Generated Hash
     * @throws \Mapper\ModelMapperException
     */
    public static function insertToken(string $clientId, string $group = 'client')
    {
        // If the specified group doesn't exists, the default group "client" will be assigned.
        $group = self::group($group) !== false ? $group : 'client';

        $model = json()::map(new TokenDefinition(), ['clientId' => $clientId, 'groupId' => $group]);

        $token = database()->insert('token', $model, self::generateHash());

        logger()::log($token, 'token', "a token was generated on raise. (clientId:: {$clientId}).", $model);

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
    public static function generateHash()
    {
        return bin2hex(openssl_random_pseudo_bytes(20));
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
        $model = database()->select('token', $token->token);

        // Check if the Token exists on the Database and check if is valid
        if ($model == false || $model->expireTime < microtime(true)) {
            response()::message(401, 'Your Token is Invalid or Expired');

            return false;
        }

        return $model;
    }

    /**
     * Check if the Request Payload it's valid
     * If is return it Mapped in the given Model
     * If not, return a false boolean.
     *
     * @param string $modelName the Model to be validated
     * @param object $body the Payload to be validated
     * @param string $action the defined action
     *
     * @return bool|object|Model the mapped model or false if doesn't exists
     */
    public static function validateBody(string $modelName, $body, $action = '')
    {
        $model = ('App\Models\Communication\\' . ucwords($modelName));

        if (class_exists($model)) {
            return json()::validate($model, $body, $action) ?? false;
        }

        return false;
    }

    /**
     * Get a specific Group/Profile by the Unique Name.
     *
     * @param string $uniqueName the unique name of the profile/group
     *
     * @return mixed|bool return the document and the unique identifier if the group exists if not return false
     */
    public static function group(string $uniqueName)
    {
        // Search for the Group
        $group = database()->select('profile', (new Select())->where('uniqueName', $uniqueName)->limit(1));

        // Return the current Group
        return current($group);
    }

    /**
     * Check if a permission exists or if a group has a specific permission.
     *
     * @param string $name the name of the permission
     * @param string|null $group the unique group name
     *
     * @return bool return true if permission exists, or if the permission exists and the group has the permission,
     *              false if the group doesn't exists, or if the permission doesn't exists or if the permission exists and the group exists
     *              but the group doesn't have this permission.
     */
    public static function permission(string $name, string $group = null)
    {
        // Try to gather the permission
        $permission = database()->select('permission', (new Select())->where('name', $name)->limit(1));

        // If the group is not specified checks if the group exists
        if ($group === null) {
            return current($permission) !== false;
        }

        // Group specified, try to gather the group
        $group = current(database()->select('profile', (new Select())->where('uniqueName', $group)->limit(1)));

        return $group !== false && in_array($name, $group->document->permissions);
    }
}
