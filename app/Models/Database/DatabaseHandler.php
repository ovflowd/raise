<?php

namespace App\Models\Database;

/**
 * Class DatabaseHandler.
 */
abstract class DatabaseHandler
{
    /**
     * Connect to the Database.
     *
     * @param array $connection
     *
     * @return mixed
     */
    abstract public function connect(array $connection);

    /**
     * Destroy the Connection.
     *
     * @return mixed
     */
    abstract public function destroy();

    /**
     * Insert Data on Database.
     *
     * @param string $table
     * @param $data
     * @param null $parameters
     *
     * @return mixed
     */
    abstract public function insert(String $table, $data, $parameters = null);

    /**
     * Select Data on Database.
     *
     * @param string $table
     * @param $data
     * @param null $parameters
     *
     * @return mixed
     */
    abstract public function select(String $table, $data, $parameters = null);
}
