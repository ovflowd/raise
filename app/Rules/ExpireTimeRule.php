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

namespace App\Rules;

use Common\ModelReflection\ModelProperty;
use Validator\IRule;
use Validator\ModelValidatorException;

/**
 * Class ExpireTimeRule.
 *
 * A Mapping Rule used to set the Token Expire Time
 *
 * @version 2.1.0
 *
 * @since 2.1.0
 */
class ExpireTimeRule implements IRule
{
    /**
     * Used in your @rule annotation (single value)
     * Can have aliases (hence the array)
     * Case insensitive
     *
     * @return array
     */
    function getNames()
    {
        return ['expireTime'];
    }

    /**
     * Calculate the Height of Expire Time
     *
     * @param float $time Current Time
     * @return false|int Expire Time
     */
    static function calculate(float $time)
    {
        return strtotime('+' . setting('security.expireTime'), $time);
    }

    /**
     * Define your rule and have your property pass it
     * Additional rule parameters are stored inside $params
     * Should throw an Exception on failure
     *
     * @param ModelProperty $property
     * @param array $params
     *
     * @throws \Throwable
     */
    function validate(ModelProperty $property, array $params = array())
    {
        $property->setPropertyValue(self::calculate($property->getPropertyValue()));
    }
}