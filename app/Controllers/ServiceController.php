<?php

namespace App\Controllers;

use Koine\QueryBuilder\Statements\Select;

/**
 * Class ServiceController.
 */
class ServiceController extends BaseController
{
    /**
     * Register Process.
     *
     * @return void
     */
    public function register()
    {
        global $token;

        if (($mappedModel = security()::validateBody('service', request()::body())) == false) {
            response()::setResponse(400, 'Missing required Parameters');

            return;
        }

        $mappedModel->clientId = $token()->clientId;

        database()->insert('service', $mappedModel);

        response()::setResponse(200, 'Service Registered Successfully');
    }

    /**
     * List Process.
     *
     * @param string            $modelName
     * @param array|object|null $list
     */
    public function list(string $modelName = null, $list = null)
    {
        global $token;

        $query = $this->filter();

        $query->where('clientId', $token()->clientId);

        $list = database()->select('service', $query);

        parent::list('service', $list);
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

        if (($id = request()::query('id')) !== false) {
            $query->where("META(service).id = '{$id}'");

            return $query;
        }

        if (request()::query('serviceName') !== false) {
            $query->where('serviceName', request()::query('serviceName'));
        }

        return parent::filter($query);
    }
}
