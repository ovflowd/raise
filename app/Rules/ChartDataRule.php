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
 * Class ChartDataRule.
 *
 * A Mapping Rule used to map the Chart Data
 *
 * @see https://www.ietf.org/rfc/rfc2822.txt
 *
 * @version 2.1.0
 *
 * @since 2.1.0
 */
class ChartDataRule implements IRule
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
        return ['chartData'];
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
        $temporary = [];

        foreach ($property->getPropertyValue() as $value) {
            $temporary[date('Y-m-d h:i', $value->document->clientTime)]++;
        }

        $final = [];

        foreach ($temporary as $date => $amount) {
            $final[] = ['x' => $date, 'y' => $amount];
        }

        $property->setPropertyValue($final);
    }
}