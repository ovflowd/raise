<?php

namespace App\Handlers;

use App\Models\Database\DatabaseHandler;
use Couchbase\N1qlQuery;
use Koine\QueryBuilder\Statements\Select;

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
     * @param array|object $connection
     *
     * @return void
     */
    public function connect($connection)
    {
        $this->connection = new \CouchbaseCluster("{$connection->address},{$connection->user},{$connection->password}");
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
     * @return int The Unique Object Identifier
     */
    public function insert(string $table, $data, $parameters = null)
    {
        $itemId = openssl_random_pseudo_bytes(200);

        $this->connection->openBucket($table)->insert($itemId, $data);

        return $itemId;
    }

    /**
     * Select Data on Database.
     *
     * @param string $table
     * @param null   $parameters
     *
     * @return mixed
     */
    public function select(string $table, $parameters = null)
    {
        $query = new Select();

        $query->select('*');

        $query->from($table);

        $query->where($parameters);

        return $this->connection->openBucket($table)->query(N1qlQuery::fromstring($query->toSql()))->rows;
    }

    /**
     * Select an Object by its Identifier.
     *
     * @param string $table
     * @param string $id
     *
     * @return object|null
     */
    public function selectById(string $table, string $id)
    {
        return $this->connection->openBucket($table)->get($id)->value;
    }
}
