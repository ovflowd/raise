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

namespace UIoT\Mappers;

/**
 * Class Constants
 * @package UIoT\Mappers
 */
final class Constants
{
    /**
     * Create a new Instance of Constants Class if does'nt exists
     *
     * This method does the Singleton Routine Pattern
     * to get the instance of Constants class.
     *
     * @return Constants
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
     * Define a Constant
     *
     * @param string $constantName Name
     * @param string $constantValue Value
     */
    public function add($constantName, $constantValue)
    {
        defined($constantName) || define($constantName, $constantValue);
    }

    /**
     * Return a Constant
     *
     * @param string $constantName
     * @return string
     */
    public function get($constantName)
    {
        return defined($constantName) ? constant($constantName) : '';
    }
}
