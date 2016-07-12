<?php

namespace UIoT\database;

use PDO;
use PDOStatement;
use UIoT\messages\DatabaseErrorFailedMessage;
use UIoT\messages\EmptyArgumentsMessage;
use UIoT\messages\RequiredArgumentMessage;
use UIoT\messages\ResourceItemAddedMessage;
use UIoT\messages\ResourceItemDeleteMessage;
use UIoT\messages\ResourceItemUpdatedMessage;
use UIoT\sql\SQLWords;
use UIoT\util\MessageHandler;
use UIoT\util\RequestInput;

/**
 * Class DatabaseManager
 * @package UIoT\database
 */
class DatabaseManager
{
    /**
     * @var PDO
     */
    private static $databaseInstance;

    /**
     * DatabaseManager constructor.
     */
    public function __construct()
    {
        if (null == static::$databaseInstance) {
            static::$databaseInstance = (new DatabaseHandler)->getInstance();
        }
    }

    /**
     * Get Database Instance
     *
     * @return PDO
     */
    public function getInstance()
    {
        return static::$databaseInstance;
    }

    /**
     * Get Last Inserted Id
     *
     * @return string
     */
    public function getLastId()
    {
        return static::$databaseInstance->lastInsertId();
    }

    /**
     * Prepares a query
     *
     * @param string $query
     * @return PDOStatement
     */
    public function prepare($query)
    {
        return static::$databaseInstance->prepare($query);
    }

    /**
     * Get Row Count
     *
     * @param PDOStatement $query
     * @return mixed
     */
    public function rowCount(PDOStatement $query)
    {
        return $query->rowCount();
    }

    /**
     * Fetch a query all rows
     *
     * @param PDOStatement $query
     * @return mixed
     */
    public function fetchAll(PDOStatement $query)
    {
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Fetch a query single row
     *
     * @param PDOStatement $query
     * @return mixed
     */
    public function fetch(PDOStatement $query)
    {
        return $query->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Executes a Query
     *
     * @param PDOStatement $query
     * @param array $statements
     * @return mixed
     */
    public function execute($query, array $statements = [])
    {
        return $query->execute($statements);
    }

    /**
     * Prepares a Query and Execute it
     *
     * @param string $query
     * @param array $statement
     * @return mixed
     */
    public function fastExecute($query, array $statement = [])
    {
        return $this->execute($this->prepare($query), $statement);
    }

    /**
     * Prepare, Execute and Fetch a Query
     *
     * @param string $query
     * @param array $statements
     * @return array
     */
    public function fetchExecute($query, array $statements = [])
    {
        $this->execute($statement = $this->prepare($query), $statements);

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Prepare, Execute and Counts number of Rows from a Query
     *
     * @param string $query
     * @param array $statements
     * @return array
     */
    public function rowCountExecute($query, array $statements = [])
    {
        $this->execute($statement = $this->prepare($query), $statements);

        return $statement->rowCount();
    }

    /**
     * Does an UIoT action query
     *
     * @param $query
     * @param array $statements
     * @return string|mixed|array
     */
    public function action($query, array $statements = [])
    {
        $this->execute($statement = $this->prepare($query), $statements);

        if ($statement->errorInfo()[0] == null || $statement->errorInfo()[0] == "0000") {
            return $this->actionSwitch($query, $statement);
        }

        return $this->actionError($statement);
    }

    /**
     * UIoT action error solution handler
     *
     * @param PDOStatement $statement
     * @return string
     */
    private function actionError($statement)
    {
        switch ($statement->errorCode()) {
            default:
                return MessageHandler::getInstance()->getResult(new DatabaseErrorFailedMessage($statement->errorCode(), $statement->errorInfo()[2]));
            case 'HY000':
                return MessageHandler::getInstance()->getResult(new RequiredArgumentMessage(
                    RequestInput::getResource()->getPropertiesFriendlyNames()[explode("'", $statement->errorInfo()[2])[1]]));
            case '21S01':
                return MessageHandler::getInstance()->getResult(new EmptyArgumentsMessage(RequestInput::getResource()->getId()));
        }
    }

    /**
     * UIoT action solution handler
     *
     * @param string $query
     * @param PDOStatement $prepared
     * @return string
     */
    private function actionSwitch($query, $prepared)
    {
        switch (substr($query, 0, 6)) {
            default:
            case SQLWords::getSelect():
                return RequestInput::nameToFriendlyName($prepared->fetchAll(PDO::FETCH_OBJ));
            case SQLWords::getUpdate():
                if (strpos($query, 'SET DELETED=1') !== false) {
                    return MessageHandler::getInstance()->getResult(new ResourceItemDeleteMessage);
                }
                return MessageHandler::getInstance()->getResult(new ResourceItemUpdatedMessage);
            case SQLWords::getInsert():
                return MessageHandler::getInstance()->getResult(new ResourceItemAddedMessage);
            case SQLWords::getDelete():
                return MessageHandler::getInstance()->getResult(new ResourceItemDeleteMessage);
        }
    }
}
