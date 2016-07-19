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
     * @return bool If the Token does'nt exists return false, if exists return true
     */
    public function setToken($tokenHash = '')
    {
        if (DatabaseManager::getInstance()->rowCount(Constants::getInstance()->get('specificTokenDetailsQuery'), [
                ':DVC_TOKEN' => $tokenHash
            ]) == 0
        ) {
            return false;
        }

        $this->sessionToken = Json::getInstance()->convert(DatabaseManager::getInstance()->fetch(
            Constants::getInstance()->get('specificTokenDetailsQuery'), [
            ':DVC_TOKEN' => $tokenHash
        ]), new TokenModel);

        return true;
    }

    /**
     * Insert a Token in the Database
     *
     * @param int $deviceId Device Identification
     */
    public function createToken($deviceId = 0)
    {
        DatabaseManager::getInstance()->query(Constants::getInstance()->get('addTokenQuery'), [
            ':DVC_ID' => $deviceId,
            ':DVC_TOKEN' => Security::getInstance()->generateSha1(),
            ':DVC_TOKEN_EXPIRE' => Time::getInstance()->getTime()
        ]);
    }

    /**
     * Check if the Token of the Session is Valid
     *
     * @return bool If the Token is Valid
     */
    public function checkToken()
    {
        if ($this->getToken() === null) {
            return false;
        }

        return Time::getInstance()->compareTimes($this->getToken()->getExpiration(), Time::getInstance()->getTime());
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
