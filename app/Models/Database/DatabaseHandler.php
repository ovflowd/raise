<?php

namespace App\Models\Database;

/**
 * Class DatabaseHandler.
 */
abstract class DatabaseHandler
{
    /**
     * Connect to the Database
     *
     * @param array $connection
     * @return mixed
     */
    public abstract function connect(array $connection);

    /**
     * Destroy the Connection
     *
     * @return mixed
     */
    public abstract function destroy();

    /**
     * Insert Data on Database
     *
     * @param String $table
     * @param $data
     * @param null $parameters
     * @return mixed
     */
    public abstract function insert(String $table, $data, $parameters = null);

    /**
     * Select Data on Database
     *
     * @param String $table
     * @param $data
     * @param null $parameters
     * @return mixed
     */
    public abstract function select(String $table, $data, $parameters = null);
}
