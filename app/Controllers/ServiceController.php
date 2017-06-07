<?php

namespace App\Controllers;

use App\Models\Communication\Model;
use App\Models\Communication\ServiceModel;
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
     * @param null $data
     * @param Model|null $responseModel
     */
    public function register($data = null, Model $responseModel = null)
    {
        if (($serviceBag = security()::validateBody('servicebag', request()::body())) == false) {
            response()::setResponse(400, 'Missing required Parameters');

            return;
        }

        $response = array_map(function (ServiceModel $service) {
            $service->id = database()->insert('service', $service);

            database()->update('service', $service->id, $service);

            return array('id' => $service->id, 'name' => $service->name);
        }, $serviceBag->services);

        parent::register(array('services' => $response, 'message' => 'Success'), new ServiceRegisterResponse());
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

        $data = database()->select('service', $query);

        parent::list($data, new ServiceListResponse(), function ($services) {
            return array('services' => json()::mapSet(new ServiceModel(), $services));
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
        global $token;

        $query = new Select();

        $query->where('clientId', $token()->clientId);

        if (request()::query('id') !== false) {
            $query->where('META(document).id', request()::query('id'));
        }

        if (request()::query('serviceName') !== false) {
            $query->where('serviceName', request()::query('serviceName'));
        }

        return parent::filter($query);
    }
}
