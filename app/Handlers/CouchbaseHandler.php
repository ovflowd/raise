<?php

namespace App\Handlers;

use App\Models\Communication\Model;
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
     * @param Model  $data
     * @param string $primaryKey
     *
     * @return string Document Identifier
     */
    public function insert(string $table, Model $data, string $primaryKey = null)
    {
        $itemId = $primaryKey ?? bin2hex(openssl_random_pseudo_bytes(20));

        $this->connection->openBucket($table)->insert($itemId, $data->encode());

        return $itemId;
    }

    /**
     * Select Data on Database.
     *
     * @param string $table
     * @param Select $query
     *
     * @return mixed
     */
    public function select(string $table, Select $query)
    {
        $query->select('*')->from("{$table} document");

        return $this->connection->openBucket($table)->query(N1qlQuery::fromstring($query->toSql()))->rows;
    }

    /**
     * Select an Object by its Identifier.
     *
     * @param string $table
     * @param string $primaryKey
     *
     * @return object|bool
     */
    public function selectById(string $table, string $primaryKey)
    {
        try {
            $result = $this->connection->openBucket($table)->get($primaryKey);

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
    public function count(string $table, string $primaryKey)
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
     * @param string $primaryKey
     * @param Model  $data
     *
     * @return mixed
     */
    public function update(string $table, string $primaryKey, Model $data)
    {
        try {
            $result = $this->connection->openBucket($table)->upsert($primaryKey, $data->encode());

            return $result->value;
        } catch (Exception $e) {
            return false;
        }
    }
}
