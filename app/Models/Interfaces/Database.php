<?php

namespace App\Models\Interfaces;

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
     * @return mixed
     */
    public function connect($connection);

    /**
     * Destroy the Connection.
     *
     * @return mixed
     */
    public function destroy();

    /**
     * Insert Data on Database.
     *
     * @param string $table
     * @param $data
     * @param null $parameters
     *
     * @return mixed
     */
    public function insert(string $table, $data, $parameters = null);

    /**
     * Select Data on Database.
     *
     * @param string $table
     * @param null   $parameters
     *
     * @return mixed
     */
    public function select(string $table, $parameters = null);

    /**
     * Count number of Elements of a specific Query.
     *
     * @param string $table
     * @param null   $parameters
     *
     * @return mixed
     */
    public function count(string $table, $parameters = null);

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
