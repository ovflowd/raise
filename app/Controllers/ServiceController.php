<?php

namespace App\Controllers;

use App\Facades\RequestFacade;
use App\Facades\SecurityFacade;
use App\Managers\DatabaseManager;
use App\Managers\ResponseManager;
use App\Models\Response\TokenResponse;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class ServiceController.
 */
class ServiceController extends BaseController
{
    /**
     * Register Process.
     *
     * @return mixed
     */
    public function register()
    {
        if (($mappedModel = SecurityFacade::validateBody('service', RequestFacade::body())) == false) {
            ResponseManager::get()->setResponse(400, 'Missing required paramaters');

            var_dump($mappedModel);

            return;
        }

        DatabaseManager::insert('service', $mappedModel);

        ResponseManager::get()->setResponse(200, 'Service Registered Successfully');
    }

    /**
     * List Process.
     *
     * @param string     $modelName
     * @param array|null $list
     */
    public function list(string $modelName = null, array $list = null)
    {
        // TODO: Implement list() method.
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

        return parent::filter($query);
    }
}
