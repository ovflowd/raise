<?php

namespace App\Controllers;

use App\Models\Response\ServiceListResponse;
use App\Models\Response\ServiceRegisterResponse;
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

        $servicesResponse = array();

        array_walk($mappedModel->services, function ($service) use ($mappedModel, &$servicesResponse) {
            $service->clientTime = $mappedModel->clientTime;
            $service->tags = $mappedModel->tags;

            $service->id = database()->insert('service', $service);

            database()->update('service', $service->id, $service);

            array_push($servicesResponse, array('id' => $service->id, 'name' => $service->name));
        });

        response()::setResponseModel(200, new ServiceRegisterResponse(),
            array('services' => $servicesResponse, 'message' => 'Success'));
    }

    /**
     * List Process.
     *
     * @param array|object|null $list
     * @param object|callable $callback
     */
    public function list($list = null, $callback = null)
    {
        global $token;

        $query = $this->filter();

        $query->where('clientId', $token()->clientId);

        $list = database()->select('service', $query);

        parent::list($list, function ($data) {
            response()::setResponseModel(200, new ServiceListResponse(), array('services' => $data));
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

        if (request()::query('serviceName') !== false) {
            $query->where('serviceName', request()::query('serviceName'));
        }

        return parent::filter($query);
    }
}
