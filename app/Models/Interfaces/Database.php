<?php

namespace App\Models\Interfaces;

use App\Models\Communication\Model;
use Koine\QueryBuilder\Statements\Select;

/**
 * Interface Database.
 */
interface Database
{
    /**
     * Connect to the Database.
     *
     * @param array|object $connection
     *
     * @return void
     */
    public function connect($connection);

    /**
     * Destroy the Connection.
     *
     * @return void
     */
    public function destroy();

    /**
     * Insert Data on Database.
     *
     * @param string       $table
     * @param object Model $data
     * @param string       $primaryKey
     *
     * @return int
     */
    public function insert(string $table, Model $data, string $primaryKey);

    /**
     * Select Data on Database.
     *
     * @param string $table
     * @param Select $query
     *
     * @return mixed
     */
    public function select(string $table, Select $query);

    /**
     * Count number of Elements of a specific Query.
     *
     * @param string $table
     * @param string $primaryKey
     *
     * @return int
     */
    public function count(string $table, string $primaryKey);

    /**
     * Update an Element of the Database.
     *
     * @param string $table
     * @param string $primaryKey
     * @param Model  $data
     *
     * @return mixed
     */
    public function update(string $table, string $primaryKey, Model $data);
}
