<?php

namespace App\Handlers;

use App\Models\Interfaces\Database;
use Couchbase\Exception;
use Couchbase\N1qlQuery;
use CouchbaseCluster;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class CouchbaseHandler.
 */
class CouchbaseHandler implements Database
{
    /**
     * Couchbase Connection Instance.
     *
     * @var CouchbaseCluster
     */
    private $connection = null;

    /**
     * Connect to the Database.
     *
     * @param array|object $connection
     */
    public function connect($connection)
    {
        $this->connection = new CouchbaseCluster("{$connection->address},{$connection->user},{$connection->password}");
    }

    /**
     * Destroy the Connection.
     */
    public function destroy()
    {
        $this->connection = null;
    }

    /**
     * Insert Data on Database.
     *
     * @param string $table
     * @param object|array $data
     * @param string $primaryKey
     * @param mixed|null $parameters
     * @return int
     */
    public function insert(string $table, $data, string $primaryKey = null, $parameters = null)
    {
        $itemId = $primaryKey ?? bin2hex(openssl_random_pseudo_bytes(20));

        if ($parameters !== null && method_exists($data, $parameters)) {
            $data->{$parameters}();
        }

        $this->connection->openBucket($table)->insert($itemId, $data);

        return $itemId;
    }

    /**
     * Select Data on Database.
     *
     * @param string $table
     * @param null $parameters
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
     * @return object|bool
     */
    public function selectById(string $table, string $id)
    {
        try {
            $result = $this->connection->openBucket($table)->get($id);

            return $result->value;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Count number of Elements of a specific Query.
     *
     * @param string $table
     * @param string $primaryKey
     *
     * @return int|bool
     */
    public function count(string $table, $primaryKey = null)
    {
        if (is_bool($primaryKey) || $primaryKey == null) {
            return false;
        }

        try {
            $elements = $this->connection->openBucket($table)->get($primaryKey);

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
