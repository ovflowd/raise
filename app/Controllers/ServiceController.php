<?php

namespace App\Controllers;

use App\Models\Communication\Model;
use App\Models\Communication\Service;
use App\Models\Response\Service;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class ServiceController.
 */
class ServiceController extends Controller
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

        $response = array_map(function (Service $service) {
            $service->id = database()->insert('service', $service);

            database()->update('service', $service->id, $service);

            return ['id' => $service->id, 'name' => $service->name];
        }, $serviceBag->services);

        parent::register(['services' => $response, 'message' => 'Success'], new Service());
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

        parent::list($data, new Service(), function ($services) {
            return ['services' => json()::mapSet(new Service(), $services)];
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
