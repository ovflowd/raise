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
 * Class UniqueNameRule.
 *
 * A Mapping Rule used to verify the uniquenes of a
 *  given Unique Name.
 *
 * @version 2.1.0
 *
 * @since 2.1.0
 */
class UniqueNameRule implements IRule
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
        return ['uniqueName'];
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
        $name = $property->getPropertyValue();

        switch ($property->getPropertyName()) {
            case 'uniqueName':
                if (security()::group($name) !== false) {
                    throw new ModelValidatorException('Already exists a group with this unique name.');
                }
                break;
            case 'name':
                if (security()::permission($name) !== false) {
                    throw new ModelValidatorException('Already exists a permission with this unique name.');
                }
                break;
        }

        // Check if unique name is alphabetic only
        if (preg_match('/^[a-z_]*$/', $name) === 0) {
            throw new ModelValidatorException('Only alphabet characters and hyphens are allowed');
        }
    }
}