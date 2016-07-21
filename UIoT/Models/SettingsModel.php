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

use UIoT\Interfaces\SettingsInterface;

/**
 * Class SettingsModel
 * @package UIoT\Models
 */
abstract class SettingsModel implements SettingsInterface
{
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
    public abstract function getBlockName();
}