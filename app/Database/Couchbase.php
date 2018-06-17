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
use Couchbase\Exception;
use Couchbase\N1qlQuery;
use Couchbase\PasswordAuthenticator;
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
     * @var PasswordAuthenticator
     */
    private $authenticator = null;

    /**
     * Connect to the Database.
     *
     * @param array|object $connection the connection string for Couchbase
     * @return bool
     */
    public function connect($connection)
    {
        try {
            $this->authenticator = new PasswordAuthenticator();

            $this->authenticator->username($connection->username);
            $this->authenticator->password($connection->password);

            $this->connection = new CouchbaseCluster("couchbase://{$connection->address}");

            $this->connection->authenticate($this->authenticator);
        } catch (Exception $e) {
            return $this->getCouchbaseResponseError($e->getCode());
        }

        return true;
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
     * @param string $table desired bucket
     * @param Model $data data to be inserted
     * @param string $primaryKey defined primary key or generated
     *
     * @return int|string generated or defined primary key or the result of the primary key
     */
    public function insert(string $table, Model $data, string $primaryKey = null)
    {
        try {
            $itemId = $primaryKey ?? bin2hex(openssl_random_pseudo_bytes(20));

            $bucket = $this->connection->openBucket($table);

            $bucket->operationTimeout = 2000;
            $bucket->httpTimeout = 500;
            $bucket->n1qlTimeout = 2000;

            return !empty($bucket->insert($itemId, $data->encode()))
                ? $itemId : false;
        } catch (Exception $e) {
            return $this->getCouchbaseResponseError($e->getCode());
        }
    }

    /**
     * Select Data on Couchbase.
     *
     * @param string $table desired table to select
     * @param string|Select|QueryBuilder $query a Select query to search
     * @param bool $override If need override the select statement
     *
     * @return Model|array|object|string selected content
     */
    public function select(string $table, $query, bool $override = true)
    {
        try {
            $bucket = $this->connection->openBucket($table);

            $bucket->operationTimeout = 2000;
            $bucket->httpTimeout = 500;
            $bucket->n1qlTimeout = 2000;

            if ($query instanceof Select) {
                $query->from("{$table} document");

                if ($override === true) {
                    $query->select('document, META(document).id');
                }

                return $bucket->query(N1qlQuery::fromString($query->toSql()))->rows;
            }

            return $bucket->get((string)$query)->value;
        } catch (Exception $e) {
            return $this->getCouchbaseResponseError($e->getCode());
        }
    }

    /**
     * Update an Element of the Couchbase.
     *
     * @param string $table desired bucket to update
     * @param string $primaryKey the document identifier
     * @param Model|object $data data to update
     *
     * @return array|string|object the result of the update
     */
    public function update(string $table, string $primaryKey, $data)
    {
        try {
            $bucket = $this->connection->openBucket($table);

            $bucket->operationTimeout = 2000;
            $bucket->httpTimeout = 500;
            $bucket->n1qlTimeout = 2000;

            $result = $bucket->upsert($primaryKey, $data);

            return $result->value;
        } catch (Exception $e) {
            return $this->getCouchbaseResponseError($e->getCode());
        }
    }

    /**
     * Delete an Element of the Database.
     *
     * @param string $table desired table to update
     * @param string $primaryKey desired element to delete
     *
     * @return bool if removed or not
     */
    public function delete(string $table, string $primaryKey)
    {
        try {
            $bucket = $this->connection->openBucket($table);

            $bucket->operationTimeout = 2000;
            $bucket->httpTimeout = 500;
            $bucket->n1qlTimeout = 2000;

            return !empty($bucket->remove($primaryKey));
        } catch (Exception $e) {
            return $this->getCouchbaseResponseError($e->getCode());
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
     * @return PasswordAuthenticator
     */
    public function getAuthenticator()
    {
        return $this->authenticator;
    }

    /**
     * Provide a Call Back to Kill the Application when Couchbase
     * has strange behaviors.
     *
     * @param int $protocolError
     */
    protected function getCouchbaseResponseError(int $protocolError)
    {
        global $response;

        switch ($protocolError) {
            case 22:
            case 23:
                response()::status("5{$protocolError}", 'Please wait, Couchbase is warming up.');

                break;
            default:
                response()::status("5{$protocolError}", 'Couchbase had a strange behavior. Please check the logs.');

                break;
        }

        $response();

        exit(1);
    }
}
