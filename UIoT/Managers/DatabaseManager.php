<?php

/**
 * UIoT Service Layer
 * @version alpha
 *                          88
 *                          ""              ,d
 *                                          88
 *              88       88 88  ,adPPYba, MM88MMM
 *              88       88 88 a8"     "8a  88
 *              88       88 88 8b       d8  88
 *              "8a,   ,a88 88 "8a,   ,a8"  88,
 *               `"YbbdP'Y8 88  `"YbbdP"'   "Y888
 *
 * @author Universal Internet of Things
 * @license MIT <https://opensource.org/licenses/MIT>
 * @copyright University of Brasília
 */

namespace UIoT\Managers;

use PDO;
use PDOStatement;
use UIoT\Handlers\DatabaseHandler;

/**
 * Class DatabaseManager
 * @package UIoT\Managers
 */
class DatabaseManager
{
    /**
     * Database Handler Instance
     *
     * @var DatabaseHandler
     */
    private $databaseHandler;

    /**
     * Get Database Manager Instance
     *
     * @return DatabaseManager
     */
    public static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Prepares, Executes a MySQL Query
     * returning a single row if exists.
     * Uses PHP's PDO Engine
     *
     * @param string $queryString MySQL Query
     * @param array $preparedStatements Array with Prepared Statements
     * @return mixed If successful a single object if not an error
     */
    public function fetch($queryString, array $preparedStatements = array())
    {
        return $this->query($queryString, $preparedStatements)->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Prepares and Executes a MySQL Query
     * through PHP's PDO Engine
     *
     * @param string $queryString MySQL Query
     * @param array $preparedStatements Array with Prepared Statements
     * @return PDOStatement Executed Statement
     */
    public function query($queryString, array $preparedStatements = array())
    {
        $statement = $this->getHandler()->getConnection()->prepare($queryString);
        $statement->execute($preparedStatements);

        return $statement;
    }

    /**
     * Get Database Handler
     *
     * @return DatabaseHandler
     */
    public function getHandler()
    {
        if (null === $this->databaseHandler) {
            $this->databaseHandler = new DatabaseHandler;
            $this->databaseHandler->connect();
        }

        return $this->databaseHandler;
    }

    /**
     * Prepares, Executes a MySQL Query
     * returning a set of rows if exists.
     * Uses PHP's PDO Engine
     *
     * @param string $queryString MySQL Query
     * @param array $preparedStatements Array with Prepared Statements
     * @return mixed|array If successful an object array if not an error
     */
    public function fetchAll($queryString, array $preparedStatements = array())
    {
        return $this->query($queryString, $preparedStatements)->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Prepares, Executes a MySQL Query
     * returning the row Count
     * Uses PHP's PDO Engine
     *
     * @param string $queryString MySQL Query
     * @param array $preparedStatements Array with Prepared Statements
     * @return mixed|int If successful a number if not an error
     */
    public function rowCount($queryString, array $preparedStatements = array())
    {
        return $this->query($queryString, $preparedStatements)->rowCount();
    }
}
