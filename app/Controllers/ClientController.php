<?php

namespace App\Controllers;

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
     * @return void
     */
    public function register()
    {
        if (($mappedModel = security()::validateBody('client', request()::body())) == false) {
            response()::setResponse(400, 'Missing required Parameters');

            return;
        }

        response()::setResponseModel(200, new TokenResponse(), [
            'message' => 'Client Registered Successfully',
            'token'   => security()::insertToken(database()->insert('client', $mappedModel)),
        ]);
    }

    /**
     * List Process.
     *
     * @param string     $modelName
     * @param array|null $list
     */
    public function list(string $modelName = null, array $list = null)
    {
        $query = $this->filter();

        $list = database()->select('client', $query);

        parent::list('client', $list);
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

        if (request()::query('tags') !== false) {
            $query->where('tags', request()::query('tags'));
        }

        return parent::filter($query);
    }
}
