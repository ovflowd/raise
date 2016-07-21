<?php

/**
 * UIoT Service Layer
 * @version alpha
 *                          88
 *                          ""              ,d
 *                                          88
 *              88       88 88  ,adPPYba, MM88MMM
 *              88       88 88 a8"     "8a  88
 *              88       88 88 8b       d8  88
 *              "8a,   ,a88 88 "8a,   ,a8"  88,
 *               `"YbbdP'Y8 88  `"YbbdP"'   "Y888
 *
 * @author Universal Internet of Things
 * @license MIT <https://opensource.org/licenses/MIT>
 * @copyright University of Brasília
 */

namespace UIoT\Managers;

use UIoT\Mappers\Constants;
use UIoT\Mappers\Json;
use UIoT\Mappers\Security;
use UIoT\Mappers\Time;
use UIoT\Models\TokenModel;

/**
 * Class TokenManager
 * @package UIoT\Managers
 */
class TokenManager
{
    /**
     * Session Token Identification
     *
     * @var TokenModel
     */
    private $sessionToken;

    /**
     * Get Token Manager Instance
     *
     * @return TokenManager
     */
    public static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Set the Token for the Session by a token hash identifier
     * This method populates the TokenModel and return a boolean
     * saying if the Token exists or not
     *
     * @param string $tokenHash Token Identifier
     */
    public function setToken($tokenHash = '')
    {
        if (($tokenDetails = DatabaseManager::getInstance()->fetch(
                Constants::getInstance()->get('specificTokenDetailsQuery'), [
                ':DVC_TOKEN' => $tokenHash
            ])) != null
        ) {
            $this->sessionToken = Json::getInstance()->convert($tokenDetails, new TokenModel);
        }
    }

    /**
     * Update the Session Token with the Default new Entries
     * Updating in the Database and in the Model
     *
     * @note this is used for Update Token Requests, since
     * each Device has an unique Token. The hash changes but the
     * Token continues attributed to this Device.
     */
    public function updateToken()
    {
        if ($this->sessionToken !== null) {
            DatabaseManager::getInstance()->query(Constants::getInstance()->get('updateTokenQuery'), [
                ':DVC_TOKEN' => ($newHash = Security::getInstance()->generateSha1()),
                ':OLD_DVC_TOKEN' => $this->sessionToken->updateHash($newHash),
                ':DVC_TOKEN_EXPIRE' => $this->sessionToken->updateExpiration(Time::getInstance()->getTime() +
                    SettingsManager::getInstance()->getItem('security')->__get('tokenUpdateTime'))
            ]);
        }
    }

    /**
     * Insert a Token in the Database
     * And get the Created Token
     *
     * @param int $deviceId Device Identification
     * @return string
     */
    public function createToken($deviceId = 0)
    {
        DatabaseManager::getInstance()->query(Constants::getInstance()->get('addTokenQuery'), [
            ':DVC_ID' => $deviceId,
            ':DVC_TOKEN' => $tokenHash = Security::getInstance()->generateSha1(),
            ':DVC_TOKEN_EXPIRE' => Time::getInstance()->getTime() +
                SettingsManager::getInstance()->getItem('security')->__get('tokenExpirationTime')
        ]);

        return $tokenHash;
    }

    /**
     * Check if the Token of the Session is Valid
     * If the `client` does'nt sent a token in query string also
     * the validation will return 0 (zero).
     *
     * If the Token isn't anymore valid (expired) will return -1
     * If is valid will return 1 (one)
     *
     * @return int (-1 : Expired, 0 : Invalid, 1 : Valid)
     */
    public function checkToken()
    {
        return ($this->getToken() == null ? 0 :
            (Time::getInstance()->compareTimes($this->getToken()->getExpiration(), Time::getInstance()->getTime())
                ? 1 : -1));
    }

    /**
     * Return the TokenModel of the Session
     *
     * @warning the value maybe can be null
     *
     * @return TokenModel
     */
    public function getToken()
    {
        return $this->sessionToken;
    }
}
