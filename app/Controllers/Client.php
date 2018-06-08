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

namespace App\Controllers;

use App\Models\Communication\Client as ClientDefinition;
use App\Models\Communication\Model;
use App\Models\Response\Client as ClientResponse;
use App\Models\Response\Token as TokenResponse;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class Client.
 *
 * A Controller that Manages all Interactions with a Client
 * or a set of Clients
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Client extends Controller
{
    /**
     * Register Process.
     *
     * Validated and Registers Clients unto the Database
     *
     * @param object $data the payload as object from the Request
     * @param Model|null $response a Response Model to be used as Response
     * @throws \Mapper\ModelMapperException
     */
	public function register($data = null, Model $response = null)
	{
		response()::message(400, 'Missing required Parameters');

		if (($clientModel = security()::validateBody('client', request()::body()))) {
			$jwtHash = security()::insertToken($clientId = database()->insert('client', $clientModel));

			parent::register(['token' => $jwtHash], new TokenResponse());

			logger()::log($clientId, 'client', 'a client were registered on raise.', $jwtHash);
		}
	}

	/**
	 * Re-validate Process.
	 *
	 * Re-validate a Client with given location and
	 * services. A new token and JWT it's generated.
     * @throws \Mapper\ModelMapperException
	 */
	public function update()
	{
		$hash = request()::headers('Authorization') ?: request()::headers('authorization');

		if (is_array(($update = security()::updateToken($hash)))) {
			$client = database()->select('client', $update['clientId']);

			$client->location = request()::body('location');

			database()->update('client', $update['clientId'], $client);

			parent::register(['details' => 'Client Updated Successfully', 'token' => $update['jwtHash']],
				new TokenResponse());
		}
	}

	/**
	 * List Process.
	 *
	 * List a set of Clients or a single Client based on the Request Parameters
	 *
	 * @param array|object|null $data the given Data to be Mapped
	 * @param Model $response the Response Model
	 * @param callable $callback an optional callback to treat the mapping result
	 */
	public function list($data = null, Model $response = null, $callback = null)
	{
		$query = $this->filter();

		$data = database()->select('client', $query);

		parent::list($data, new ClientResponse(), function ($clients) {
			return ['clients' => json()::mapSet(new ClientDefinition(), $clients)];
		});
	}

	/**
	 * Filter Input Data.
	 *
	 * Used to filter and apply a several filters and patches
	 * into a Query that will be used on the Database
	 *
	 * @param Select|null $query the Select Query class
	 *
	 * @return Select the Select Query class
	 */
	protected function filter(Select $query = null)
	{
		$query = new Select();

		if (request()::query('name') !== false) {
			$query->where('name', request()::query('name'));
		}

		if (request()::query('processor') !== false) {
			$query->where('processor', request()::query('processor'));
		}

		if (request()::query('channel') !== false) {
			$query->where('channel', request()::query('channel'));
		}

		return parent::filter($query);
	}
}
