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

namespace App\Models\Communication;

use JsonMapper_Exception;

/**
 * Class Data.
 *
 * A Data Model is a Schema Definition of
 * A Data and how it will be stored on the Database
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Data extends Raise
{
    /**
     * Each Data it's associated to a specific Service.
     *
     * serviceId is the Unique Service Identifier
     * that needs to be stored on the data to link it.
     *
     * @required
     *
     * @var string
     */
    public $serviceId = null;

    /**
     * An array that contains the order in which the
     * data will be presented.
     *
     * Data must be sent following the order in this
     * array.
     *
     * @required
     *
     * @var array
     */
    public $order = [];

    /**
     * A Set of Data.
     *
     * A data set contain an array
     * of data that follows a service parameters pattern
     * an data element need to include values for all
     * the parameters of an service.
     *
     * @required
     *
     * @var array[]
     */
    public $data = [];

    /**
     * Set a serviceId.
     *
     * This method verifies if the given serviceId
     * exists, if doesn't, throws an validation error.
     *
     * @param string $serviceId the service identifier
     *                          related to this data.
     *
     * @throws JsonMapper_Exception
     */
    public function setServiceId(string $serviceId)
    {
        if (database()->selectById('service', $serviceId) === false) {
            throw new JsonMapper_Exception();
        }

        $this->serviceId = $serviceId;
    }

    /**
     * Set the data's order.
     *
     * This method sets the order that data will be sent
     * at. The order is useful to identify which element
     * of a data set refers to which parameter of a Service
     *
     * @param array $order The array specifying the Service
     *                     parameters with a given (arbitrary/user specified) order
     *
     * @throws JsonMapper_Exception
     */
    public function setOrder(array $order)
    {
        $service = database()->selectById('data', $this->serviceId);

        if (count(array_diff($order, $service->parameters)) > 0) {
            throw new JsonMapper_Exception();
        }

        $this->order = $order;
    }

    /**
     * Sets the data.
     *
     * This method sets the data array that
     * has the same number of parameters as
     * the order array.
     *
     * @param array[] $dataSet A data set contain an array
     *                         of data that follows a service parameters pattern
     *                         an data element need to include values for all
     *                         the parameters of an service.
     *
     * @example Available on Swagger API
     */
    public function setData(array $dataSet)
    {
        $count = count($this->order);

        $this->data = array_filter($dataSet, function (array $data) use ($count) {
            return count($data) == $count;
        });
    }
}
