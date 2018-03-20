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
 * Class Client.
 *
 * A Client Model is a Schema Definition of
 * A Client and how it will be stored on the Database
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Client extends Raise
{
	/**
	 * Client Name.
	 *
	 * A Name given for the Client, can be anything
	 *
	 * @required
	 *
	 * @var string
	 */
	public $name = 'default client';

	/**
	 * Client Chipset Model.
	 *
	 * The chipset of the Client or
	 * Unique Device/Hardware Identifier
	 *
	 * @required
	 *
	 * @var string
	 */
	public $chipset = '0000000000';

	/**
	 * Client Mac Address.
	 *
	 * A Mac Address of the Network/Communication Chipset
	 * of the Client, or of the Client Gateway
	 *
	 * @see https://en.wikipedia.org/wiki/MAC_address MAC Address
	 *
	 * @required
	 *
	 * @var string
	 */
	public $mac = 'FF:FF:FF:FF';

	/**
	 * Client Serial.
	 *
	 * The Unique Serial Number/Vendor Number of the Client
	 * Given by the Industry of Vendor
	 *
	 * @required
	 *
	 * @var string
	 */
	public $serial = '1.0.0';

	/**
	 * Client Processor.
	 *
	 * The Processor Identifier, or common name
	 * or generic name to be identified
	 *
	 * @required
	 *
	 * @var string
	 */
	public $processor = 'i86-generic';

	/**
	 * Client Communication Channel.
	 *
	 * The type of communication used on the Client,
	 *
	 * @see https://en.wikipedia.org/wiki/Communications_system Communication Channels
	 *
	 * @required
	 *
	 * @var string
	 */
	public $channel = 'ieee-wireless-80211';

	/**
	 * Client Location or nearest path.
	 *
	 * Based on Latitude : Longitude
	 *
	 * @required
	 *
	 * @var string
	 */
	public $location = '-15.7757876:-48.077829';
}
