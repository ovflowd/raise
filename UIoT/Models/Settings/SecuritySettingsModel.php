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

namespace UIoT\Models\Settings;

use UIoT\Interfaces\SettingsInterface;

/**
 * Class SecuritySettingsModel
 *
 * This Model contains Settings Block of
 * RAISE security related things
 *
 * @package UIoT\Models\Settings
 */
class SecuritySettingsModel implements SettingsInterface
{
    /**
     * Token Expiration Time
     *
     * When a token is created this amount of seconds
     * are the default time to the Token expire
     *
     * @var int
     */
    private $tokenExpirationTime = 3600;

    /**
     * Token Expiration Update Time
     *
     * If a `client` does a Request before the Token expires,
     * the Expiration time is updated with a new amount.
     *
     * @var int
     */
    private $tokenUpdateTime = 3600;

    /**
     * This method returns a specific variable from the Setting Block
     * Settings blocks are static file Models created manually, and
     * can't be changed.
     *
     * @param string $variableName Variable that want to Get
     * @return mixed
     */
    public function __get($variableName)
    {
        return $this->{$variableName};
    }

    /**
     * This method returns the unique identification of the Block Name
     *
     * @return string
     */
    public function getBlockName()
    {
        return 'security';
    }
}
