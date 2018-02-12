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

class All extends Model
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
	 * A set of Data that will be returned on the Response.
	 *
	 * @var array
	 */
	public $data = [];

	/**
	 * A set of Services that will be returned on the Response.
	 *
	 * @var array
	 */
	public $services = [];

	/**
	 * A set of Clients that will be returned on the Response.
	 *
	 * @var array
	 */
	public $clients = [];
}
