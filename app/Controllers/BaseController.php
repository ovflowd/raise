<?php

namespace App\Controllers;

use App\Managers\ResponseManager;
use App\Models\Response\DataResponse;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class BaseController.
 */
abstract class BaseController
{
    /**
     * Register Process.
     *
     * @return mixed
     */
    abstract public function register();

    /**
     * List Process.
     *
     * @param string $modelName
     * @param array|null $list
     */
    public function list(string $modelName, array $list = null)
    {
        $data = array_map(function ($model) use ($modelName) {
            return $model->{$modelName};
        }, $list);

        ResponseManager::get()->setResponseModel(200, new DataResponse(), ['values' => $data]);
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
        $query = $query == null ? new Select() : $query;

        $query->where([]);

        return $query;
    }
}
