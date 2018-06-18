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

use App\Models\Communication\Model;
use App\Models\Communication\Service;
use Common\ModelReflection\ModelProperty;
use Validator\IRule;
use Validator\ModelValidatorException;

/**
 * Class UniqueNameRule.
 *
 * A Mapping Rule used to verify if a given set of parameters
 *  matches the parameters of a Service
 *
 * @version 2.1.0
 *
 * @since 2.1.0
 */
class ParameterRule implements IRule
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
        return ['parameterRule'];
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
        $service = database()->select('service', $property->getObject()->serviceId);

        $parameters = count($service->parameters);

        if ($parameters <= 1) {
            $property->setPropertyValue($service->parameters);

            return;
        }

        if (count($property->getPropertyValue()) !== $parameters) {
            throw new ModelValidatorException('Wrong amount of parameters given.');
        }

        $order = array_flip($property->getPropertyValue());

        $property->getObject()->values = array_map(function ($values) use ($service, $order, $parameters) {
            if (!is_array($values)) {
                throw new ModelValidatorException('Your data object must contain array of values.');
            }

            if ($parameters > 1 && count($values) !== $parameters) {
                throw new ModelValidatorException('Wrong amount of values given it must match the parameters.');
            }

            return $this->orderData($values, $service, $order);
        }, $property->getObject()->values);

        $property->setPropertyValue($service->parameters);
    }

    /**
     * Order a Set of Data.
     *
     * Order Data based on Service Parameters and his Order Set
     *
     * @param array $values A set of Values to be Ordered
     * @param Service|Model $service A given Service
     * @param array $order
     *
     * @return array|null Ordered Data if the Data matches the Service Parameters,
     *                    null otherwise.
     */
    protected function orderData(array $values, $service, $order)
    {
        return array_map(function ($parameter) use ($values, $order) {
            return $values[$order[$parameter]];
        }, $service->parameters);
    }
}