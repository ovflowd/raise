<?php

namespace App\Controllers;

use Koine\QueryBuilder\Statements\Select;

/**
 * Class DataController.
 */
class DataController extends BaseController
{
    /**
     * Register Process.
     *
     * @return mixed
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    /**
     * List Process.
     *
     * @param string $modelName
     * @param array|object|null $list
     */
    public function list(string $modelName = null, $list = null)
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
