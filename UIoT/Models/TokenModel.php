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

namespace UIoT\Models;

use UIoT\Interfaces\TokenInterface;

/**
 * Class TokenModel
 * @package UIoT\Models
 */
final class TokenModel implements TokenInterface
{
    /**
     * The unique identification for the device which
     * owns the token.
     *
     * @var int
     */
    public $DVC_ID;

    /**
     * Contains the SHA1 hash of the token.
     * Max length is 24.
     *
     * @var string
     */
    public $DVC_TOKEN;

    /**
     * Contains date at which the token will expire.
     * this variable is measured in seconds.
     *
     * @var int
     */
    public $DVC_TOKEN_EXPIRE;

    /**
     * Returns the Token hash.
     *
     * Necessary the token hash is a SHA1 string.
     * The hash can't be changed inside an instance of RAISE.
     *
     * The hash can be updated in the Database but this will affect RAISE
     * only in next communication. Since each communication is a Request and a Response
     *
     * @return string
     */
    public function getHash()
    {
        return $this->DVC_TOKEN;
    }

    /**
     * This method updates the token hash, but is only used for Database Commit's.
     *
     * This method is important since
     * this Model is used to reverse engineering back to Database Table
     * <DEVICE_TOKENS> or <CLIENTS_TOKENS>.
     *
     * @param string $tokenHash
     * @return string Old Hash
     */
    public function updateHash($tokenHash = '')
    {
        $oldHash = $this->DVC_TOKEN;

        $this->DVC_TOKEN = $tokenHash;

        return $oldHash;
    }

    /**
     * This method exists to increase or decrease the expiration time in seconds
     *
     * The expiration time is important to be updated if needed, since
     * this Model is used to reverse engineering back to Database Table
     * <DEVICE_TOKENS> or <CLIENTS_TOKENS>.
     *
     * @param int $insertionAmount
     * @return int New Expiration Time
     */
    public function updateExpiration($insertionAmount = 0)
    {
        $this->DVC_TOKEN_EXPIRE = $insertionAmount;

        return $this->DVC_TOKEN_EXPIRE;
    }

    /**
     * Returns the Token Expiration Time
     *
     * @note if the Expiration Time in Date Time is less that the
     * actual Time, the Token is invalid.
     *
     * @return int
     */
    public function getExpiration()
    {
        return $this->DVC_TOKEN_EXPIRE;
    }

    /**
     * Return the DeviceId or ClientId related for this Token Model.
     *
     * The method necessary does need a check if twice ClientId or DeviceId
     * variables are empty. Returning the variable that does'nt is empty.
     *
     * If twice are'nt empty, the method will give priority to DeviceId
     *
     * @return int
     */
    public function getIdentification()
    {
        return $this->DVC_ID;
    }
}
