<?php

namespace App\Controllers;

use App\Models\Communication\ClientModel;
use App\Models\Communication\Model;
use App\Models\Response\ClientListResponse;
use App\Models\Response\TokenResponse;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class ClientController.
 */
class ClientController extends BaseController
{
    /**
     * Register Process.
     *
     * @param null $data
     * @param Model|null $responseModel
     */
    public function register($data = null, Model $responseModel = null)
    {
        if (($clientModel = security()::validateBody('client', request()::body())) == false) {
            response()::setResponse(400, 'Missing required Parameters');

            return;
        }

        $jwtHash = security()::insertToken(database()->insert('client', $clientModel));

        parent::register(array('message' => 'Client Registered Successfully', 'token' => $jwtHash),
            new TokenResponse());
    }

    /**
     * List Process.
     *
     * @param array|null $data
     * @param Model $response
     * @param callable $callback
     */
    public function list($data = null, Model $response = null, $callback = null)
    {
        $query = $this->filter();

        $data = database()->select('client', $query);

        parent::list($data, new ClientListResponse(), function ($clients) {
            return array('clients' => json()::mapSet(new ClientModel(), $clients));
        });
    }

    /**
     * Filter Input Data.
     *
     * @param Select|null $query
     *
     * @return Select
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
