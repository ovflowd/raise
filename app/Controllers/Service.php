<?php

namespace App\Controllers;

use App\Models\Communication\Model;
use App\Models\Communication\Service as ServiceDefinition;
use App\Models\Response\Service as ServiceResponse;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class Service.
 *
 * A Controller that Manages all Interactions with a Service
 * or a set of Services
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Service extends Controller
{
    /**
     * Register Process.
     *
     * Validated and Registers Services unto the Database
     *
     * @param object     $data     the payload as object from the Request
     * @param Model|null $response a Response Model to be used as Response
     */
    public function register($data = null, Model $response = null)
    {
        if (($serviceBag = security()::validateBody('servicebag', request()::body())) == false) {
            response()::setResponse(400, 'Missing required Parameters');

            return;
        }

        $response = array_map(function (ServiceDefinition $service) {
            $service->id = database()->insert('service', $service);

            database()->update('service', $service->id, $service);

            return ['id' => $service->id, 'name' => $service->name];
        }, $serviceBag->services);

        parent::register(['services' => $response, 'message' => 'Success'], new ServiceResponse());
    }

    /**
     * List Process.
     *
     * List a set of Services or a single Service based on the Request Parameters
     *
     * @param array|object|null $data     the given Data to be Mapped
     * @param Model             $response the Response Model
     * @param callable          $callback an optional callback to treat the mapping result
     */
    public function list($data = null, Model $response = null, $callback = null)
    {
        $query = $this->filter();

        $data = database()->select('service', $query);

        parent::list($data, new ServiceResponse(), function ($services) {
            return ['services' => json()::mapSet(new ServiceDefinition(), $services), 'message' => 'Success'];
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
