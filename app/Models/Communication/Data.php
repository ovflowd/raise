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
	 * An array that contains the parameters of the
	 * Service related to this Data.
	 *
	 * @var string[]
	 */
	public $parameters = [];

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
	 * @var array
	 */
	public $values = [];

	/**
	 * The Unique Client Identifier.
	 *
	 * Each Service is related to an Service,
	 * this identified which Client the Service is associated
	 *
	 * @see Client
	 *
	 * @var string
	 */
	protected $clientId = '';

	/**
	 * Data constructor.
	 *
	 * Set the Timestamps of when RAISe handled
	 * this model.
	 *
	 * And set the Client Identifier
	 */
	public function __construct()
	{
		parent::__construct();

		$this->setClientId();
	}

	/**
	 * Set the Unique Client Identifier
	 * That is related to this Service.
	 *
	 * @param string|null $clientId the ClientId to be set
	 */
	public function setClientId(string $clientId = null)
	{
		global $token;

		$this->clientId = $clientId ?? $token()->clientId;
	}

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
		global $token;

		$service = database()->select('service', $serviceId);

		if ($service === false) {
			throw new JsonMapper_Exception();
		}

		if ($service->clientId !== $token()->clientId) {
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
	 * @param array $parameters The array specifying the Service
	 *                          parameters with a given (arbitrary/user specified) order
	 *
	 * @throws JsonMapper_Exception
	 */
	public function setOrder(array $parameters)
	{
		global $order;

		$service = database()->select('service', $this->serviceId);

		if (count(array_diff($parameters, $service->parameters)) > 0) {
			throw new JsonMapper_Exception();
		}

		$order = array_flip($parameters);
	}

	/**
	 * Sets the data.
	 *
	 * This method sets the data array that
	 * has the same number of parameters as
	 * the order array.
	 *
	 * @param array $dataSet A data set contain an array
	 *                       of data that follows a service parameters pattern
	 *                       an data element need to include values for all
	 *                       the parameters of an service.
	 *
	 * @example Available on Swagger API
	 */
	public function setValues(array $dataSet)
	{
		global $order;

		$service = database()->select('service', $this->serviceId);

		$this->values = array_map(function ($values) use ($service, $order) {
			return isset($order) ? $this->orderData($values, $service) : (array)$values;
		}, $dataSet);

		$this->parameters = $service->parameters;
	}

	/**
	 * Order a Set of Data.
	 *
	 * Order Data based on Service Parameters and his Order Set
	 *
	 * @param array $values A set of Values to be Ordered
	 * @param Service|Model $service A given Service
	 *
	 * @return array|null Ordered Data if the Data matches the Service Parameters,
	 *                    null otherwise.
	 */
	protected function orderData(array $values, $service)
	{
		global $order;

		return array_map(function ($parameter) use ($values, $order) {
			return $values[$order[$parameter]];
		}, $service->parameters);
	}

	/**
	 * Compare the size of two Arrays.
	 *
	 * @param array $needle Array to compare
	 * @param array $haystack Array to be compared
	 *
	 * @return bool If has same size or not
	 */
	protected function checkSize(array $needle, array $haystack)
	{
		return count($haystack) === count($needle);
	}
}
