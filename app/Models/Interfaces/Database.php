<?php

namespace App\Models\Interfaces;

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
     * @param string $table
     * @param object $data
     * @param string $primaryKey
     * @param mixed|null $parameters
     *
     * @return int
     */
    public function insert(string $table, $data, string $primaryKey, $parameters = null);

    /**
     * Select Data on Database.
     *
     * @param string $table
     * @param Select|null $query
     *
     * @return mixed
     */
    public function select(string $table, Select $query = null);

    /**
     * Count number of Elements of a specific Query.
     *
     * @param string $table
     * @param mixed|null $primaryKey
     *
     * @return int
     */
    public function count(string $table, $primaryKey = null);

    /**
     * Update an Element of the Database.
     *
     * @param string $table
     * @param $elementIdentifier
     *
     * @return mixed
     */
    public function update(string $table, $elementIdentifier);
}
