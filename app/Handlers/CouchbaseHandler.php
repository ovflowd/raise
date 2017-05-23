<?php

namespace App\Handlers;

use App\Models\Database\DatabaseHandler;
use Couchbase\N1qlQuery;

/**
 * Class CouchbaseHandler.
 */
class CouchbaseHandler extends DatabaseHandler
{
    /**
     * Couchbase Connection Instance.
     *
     * @var \CouchbaseCluster
     */
    private $connection = null;

    /**
     * Connect to the Database.
     *
     * @param array $connection
     *
     * @return void
     */
    public function connect(array $connection)
    {
        $this->connection = new \CouchbaseCluster("{$connection['address']},{$connection['user']},{$connection['password']}");
    }

    /**
     * Destroy the Connection.
     *
     * @return void
     */
    public function destroy()
    {
        $this->connection = null;
    }

    /**
     * Insert Data on Database.
     *
     * @param string $table
     * @param $data
     * @param null $parameters
     *
     * @return void
     */
    public function insert(String $table, $data, $parameters = null)
    {
        $itemId = openssl_random_pseudo_bytes(200);

        $this->connection->openBucket($table)->insert($itemId, $data);
    }

    /**
     * Select Data on Database.
     *
     * @param string $table
     * @param null   $parameters
     *
     * @return mixed
     */
    public function select(String $table, $parameters = null)
    {
        $params = '';
        $lastParam = end($parameters);

        foreach ($parameters as $name => $value) {
            if ($lastParam == $value) {
                $params .= "{$name} = '{$value}'";
            } else {
                $params .= "{$name} = '{$value}',";
            }
        }

        return $this->connection->openBucket($table)->query(N1qlQuery::fromString("SELECT * FROM {$table} WHERE {$params}"))->rows;
    }
}
