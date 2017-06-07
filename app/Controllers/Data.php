<?php

namespace App\Controllers;

use App\Models\Communication\Model;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class Data
 *
 * A Controller that Manages all Interactions with a Data
 * or a set of Data
 *
 * @version 2.0.0
 * @since 2.0.0
 */
class Data extends Controller
{
    /**
     * Register Process.
     *
     * Validated and Registers Data unto the Database
     *
     * @param object $data the payload as object from the Request
     * @param Model|null $response a Response Model to be used as Response
     */
    public function register($data = null, Model $response = null)
    {
        // TODO: Implement register() method.
    }

    /**
     * List Process.
     *
     * List a set of Data or a single Data based on the Request Parameters
     *
     * @param array|object|null $data the given Data to be Mapped
     * @param Model $response the Response Model
     * @param callable $callback an optional callback to treat the mapping result
     */
    public function list($data = null, Model $response = null, $callback = null)
    {
        // TODO: Implement list() method.
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
        $query = new Select();

        return parent::filter($query);
    }
}
