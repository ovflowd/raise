<?php

/**
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

namespace App\Database;

use App\Models\Communication\Model;
use App\Models\Interfaces\Database as DatabaseHandler;
use Couchbase\ClassicAuthenticator;
use Couchbase\Exception;
use Couchbase\N1qlQuery;
use CouchbaseCluster;
use Koine\QueryBuilder;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class Couchbase.
 *
 * A Couchbase Handler is a Database Handler that
 * Handles and does all operations with a Couchbase Database
 *
 * @see CouchbaseCluster You will need Couchbase PHP SDK!
 * @see https://developer.couchbase.com/documentation/server/current/introduction/intro.html Couchbase Documentation
 * @see https://en.wikipedia.org/wiki/Chain-of-responsibility_pattern CR Design Pattern
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Couchbase implements DatabaseHandler
{
    /**
     * The Couchbase Cluster Connection Instance.
     *
     * @var CouchbaseCluster
     */
    private $connection = null;

    /**
     * The Couchbase Authenticator.
     *
     * @var ClassicAuthenticator
     */
    private $authenticator = null;

    /**
     * Connect to the Database.
     *
     * @param array|object $connection the connection string for Couchbase
     */
    public function connect($connection)
    {
        $this->connection = new CouchbaseCluster("couchbase://{$connection->address}");

        $this->authenticator = new ClassicAuthenticator();
        $this->authenticator->cluster($connection->username, $connection->password);

        $this->connection->authenticate($this->authenticator);
    }

    /**
     * Destroy the Connection.
     */
    public function destroy()
    {
        $this->connection = null;
    }

    /**
     * Insert Documents on Couchbase.
     *
     * @param string $table      desired bucket
     * @param Model  $data       data to be inserted
     * @param string $primaryKey defined primary key or generated
     *
     * @return int|string generated or defined primary key or the result of the primary key
     */
    public function insert(string $table, Model $data, string $primaryKey = null)
    {
        $itemId = $primaryKey ?? bin2hex(openssl_random_pseudo_bytes(20));

        $this->connection->openBucket($table)->insert($itemId, $data->encode());

        return $itemId;
    }

    /**
     * Select Data on Couchbase.
     *
     * @param string                     $table    desired table to select
     * @param string|Select|QueryBuilder $query    a Select query to search
     * @param bool                       $override If need override the select statement
     *
     * @return Model|array|object|string selected content
     */
    public function select(string $table, $query, bool $override = true)
    {
        $bucket = $this->connection->openBucket($table);

        if ($query instanceof Select) {
            $query->from("{$table} document");

            if ($override === true) {
                $query->select('document, META(document).id');
            }

            return $bucket->query(N1qlQuery::fromString($query->toSql()))->rows;
        }

        return $bucket->get((string) $query)->value;
    }

    /**
     * Update an Element of the Couchbase.
     *
     * @param string       $table      desired bucket to update
     * @param string       $primaryKey the document identifier
     * @param Model|object $data       data to update
     *
     * @return array|string|object the result of the update
     */
    public function update(string $table, string $primaryKey, $data)
    {
        try {
            $result = $this->connection->openBucket($table)->upsert($primaryKey, $data);

            return $result->value;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Delete an Element of the Database.
     *
     * @param string $table      desired table to update
     * @param string $primaryKey desired element to delete
     *
     * @return bool if removed or not
     */
    public function delete(string $table, string $primaryKey)
    {
        try {
            $this->connection->openBucket($table)->remove($primaryKey);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the Couchbase Connection Handler.
     *
     * @return CouchbaseCluster
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Get the Couchbase Authenticator Handler.
     *
     * @return ClassicAuthenticator
     */
    public function getAuthenticator()
    {
        return $this->authenticator;
    }
}
