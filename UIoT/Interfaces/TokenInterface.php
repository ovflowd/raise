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

namespace UIoT\Interfaces;

/**
 * Interface TokenInterface
 *
 * The RAISE Tokens are the Identification of a Communication
 * between RAISE and a `client`
 *
 * Necessary the Token identifies a Device or a Client
 *
 * @package UIoT\Interfaces
 */
interface TokenInterface
{
    /**
     * The Token Interface constructor set the Information from the Token Model
     *
     * `DeviceId` and `ClientId` are Optional Fields, since only one of those
     * are filled. A Token can be linked with a Device or a Client <Application>
     *
     * @param string $tokenHash Is the generated Token Hash, necessary a SHA1 hash
     * @param int $tokenExpiration It's the Token Expiration Time in Seconds
     * @param int $deviceId It's the Device Id, 0 if doesn't have a Device
     * @param int $clientId It's the Application Id, 0 if doesn't have an Application
     */
    public function __construct($tokenHash, $tokenExpiration, $deviceId = 0, $clientId = 0);

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
    public function getHash();

    /**
     * This method updates the token hash, but is only used for Database Commit's.
     *
     * This method is important since
     * this Model is used to reverse engineering back to Database Table
     * <DEVICE_TOKENS> or <CLIENTS_TOKENS>.
     *
     * @param string $tokenHash
     * @return void
     */
    public function updateHash($tokenHash = '');

    /**
     * This method exists to increase or decrease the expiration time in seconds
     *
     * The expiration time is important to be updated if needed, since
     * this Model is used to reverse engineering back to Database Table
     * <DEVICE_TOKENS> or <CLIENTS_TOKENS>.
     *
     * @param int $insertionAmount
     * @return void
     */
    public function updateExpiration($insertionAmount = 0);

    /**
     * Returns the Token Expiration Time
     *
     * @note if the Expiration Time in Date Time is less that the
     * actual Time, the Token is invalid.
     *
     * @return int
     */
    public function getExpiration();

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
    public function getIdentification();
}
