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

/**
 * Class Token.
 *
 * A Token Model is a Schema Definition of
 * A Token and how it will be stored on the Database
 *
 * @version 2.1.0
 *
 * @since 2.0.0
 */
class Token extends Raise
{
	/**
	 * The Client Unique Identifier.
	 *
	 * Each Token expires, but the Client Definition does not,
	 * each Token it's related to an Unique Client,
	 *
	 * Token changes, Clients doesn't not.
	 *
	 * @required
	 *
	 * @var string
	 */
	public $clientId;

	/**
	 * The Group Unique Name.
	 *
	 * Tokens are related to groups, so this property
	 *  it's used to link Tokens and their Clients with Groups.
	 *
	 * Groups are specified in Tokens because
	 *
	 * @var string
	 */
	public $groupId;

	/**
	 * Token Expire Time.
	 *
	 * When the Token goes expire,
	 * in seconds.milliseconds on UNIX Timestamp
	 *
	 * @var float
	 */
	public $expireTime;

	/**
	 * Token constructor.
	 *
	 * Set the Timestamps of when RAISe handled
	 * this model.
	 *
	 * And set the ExpireTime
	 */
	public function __construct()
	{
		parent::__construct();

		$this->setExpireTime();
	}

	/**
	 * Set the Token Expire Time.
	 *
	 * @param bool $neverExpire
	 * @return $this
	 */
	public function setExpireTime($neverExpire = false)
	{
		$this->expireTime = (!$neverExpire ? strtotime('+' . setting('security.expireTime'),
			$this->serverTime) : 2145916800);

		return $this;
	}
}
