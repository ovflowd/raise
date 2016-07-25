<?php

/**
 * UIoT Service Layer
 * @version beta
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
 * Class Security
 * @package UIoT\Mappers
 */
class Security
{
    /**
     * Create a new Instance of Security if does'nt exists
     *
     * This method does the Singleton Routine Pattern
     * to get the instance of Json class.
     *
     * @return Security
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
     * Generates a SHA1 hash.
     *
     * This method generates a secure hash algorithm
     * using php's unique identification generator
     * with a random number
     *
     * @return string
     */
    public function generateSha1()
    {
        return sha1(uniqid(rand(), true)); // TODO: needs a better token generation.
    }
}
