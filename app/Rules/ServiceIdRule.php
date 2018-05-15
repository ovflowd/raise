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
 * Class ServiceIdRule.
 *
 * A Mapping Rule used to verify a specific ServiceId
 *
 * @version 2.1.0
 *
 * @since 2.1.0
 */
class ServiceIdRule implements IRule
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
        return ['serviceId'];
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
        global $token;

        $service = database()->select('service', $property->getPropertyValue());

        if ($service === false) {
            throw new ModelValidatorException('Service not Found or not valid.');
        }

        if ($service->clientId !== $token()->clientId) {
            throw new ModelValidatorException('Provided Service doesn\'t belong to current Token.');
        }
    }
}