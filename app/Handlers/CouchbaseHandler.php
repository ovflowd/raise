<?php

namespace App\Handlers;

use App\Models\Interfaces\Database;
use Couchbase\Exception;
use Couchbase\N1qlQuery;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class CouchbaseHandler.
 */
class CouchbaseHandler implements Database
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
     * @param string       $table
     * @param object|array $data
     * @param null         $parameters
     *
     * @return int The Unique Object Identifier
     */
    public function insert(string $table, $data, $parameters = null)
    {
        $itemId = $parameters == null ? bin2hex(openssl_random_pseudo_bytes(20)) : $parameters;

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

    /**
     * Count number of Elements of a specific Query.
     *
     * @param string   $table
     * @param null|int $parameters
     *
     * @return mixed
     */
    public function count(string $table, $parameters = null)
    {
        try {
            $elements = $this->connection->openBucket($table)->get($parameters);

            return is_array($elements) ? count($elements) : 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Update an Element of the Database.
     *
     * @param string $table
     * @param $elementIdentifier
     *
     * @return mixed
     */
    public function update(string $table, $elementIdentifier)
    {
        // TODO: Implement update() method.
    }
}
