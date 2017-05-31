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
     * @return mixed
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    /**
     * List Process.
     *
     * @return mixed
     */
    public function list()
    {
        // TODO: Implement list() method.
    }

    /**
     * Filter Input Data
     *
     * @param Select|null $query
     *
     * @return void
     */
    protected function filter(Select $query = null)
    {
        $query = new Select();

        parent::filter($query);
    }
}
