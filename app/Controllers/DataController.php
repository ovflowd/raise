<?php

namespace App\Controllers;

use App\Models\Communication\Model;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class DataController.
 */
class DataController extends BaseController
{
    /**
     * Register Process.
     *
     * @param null $data
     * @param Model|null $responseModel
     */
    public function register($data = null, Model $responseModel = null)
    {
        // TODO: Implement register() method.
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
