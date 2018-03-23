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

namespace App\Models\Response;

use App\Models\Communication\Model;

/**
 * Class Service.
 *
 * This is the Response Model of a Service
 * Contains a List of Service of a Service Register set Response
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Service extends Model
{
	/**
	 * The Applied HTTP Response Code.
	 *
	 * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Code Definitions
	 *
	 * @var int
	 */
	public $code;

	/**
	 * The HTTP Response Message from the RFC.
	 *
	 * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Message Definitions
	 *
	 * @var string
	 */
	public $message;

	/**
	 * A set of Services that will be returned on the Response.
	 *
	 * @var array
	 */
	public $services = [];

	/**
	 * Set the Services Array.
	 *
	 * Depending if is a Register or or List
	 * may be an ServiceDefinition or a simple array
	 *
	 * @param array $services array of ServiceDefinitions or simple array
	 */
	public function setServices(array $services)
	{
		$this->services = array_map(function ($service) {
			if ($service instanceof \App\Models\Communication\Service) {
				return $service;
			}

			return $service;
		}, $services);
	}
}
