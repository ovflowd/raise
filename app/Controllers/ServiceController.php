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
        if (($mappedModel = security()::validateBody('service', request()::body())) == false) {
            response()::setResponse(400, 'Missing required Parameters');

            return;
        }

        database()->insert('service', $mappedModel);

        response()::setResponse(200, 'Service Registered Successfully');
    }

    /**
     * List Process.
     *
     * @param string $modelName
     * @param array|object|null $list
     */
    public function list(string $modelName = null, $list = null)
    {
        $query = $this->filter();

        $list = request()::query('id') === false ? database()->select('service', $query)
            : database()->selectById('service', request()::query('id'));

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

        if (request()::query('serviceName') !== false) {
            $query->where('serviceName', request()::query('serviceName'));
        }

        return parent::filter($query);
    }
}
