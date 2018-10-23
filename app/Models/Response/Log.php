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
 * Class Log.
 *
 * A model to describe a log entry
 *
 * @see Message
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Log extends Model
{
	/**
	 * The Unique Identifier of the relative
	 * logged entry (service, data, client, token).
	 *
	 * @var string|null
	 */
	public $element = null;

	/**
	 * The respective table of the related
	 * logged entry (service, data, client, token).
	 *
	 * @var string|null
	 */
	public $table;

	/**
	 * The JWT Token used for the Session
	 * if it's a request that requires Token auth.
	 *
	 * @var object
	 */
	public $token = null;

	/**
	 * The time when the server handled the operation and inserted it.
	 *
     * @rule serverTime
     *
	 * @var float
	 */
	protected $serverTime = 0;
}
