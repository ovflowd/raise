<?php

namespace App\Controllers;

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
     * @return mixed
     */
    abstract public function list();

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
