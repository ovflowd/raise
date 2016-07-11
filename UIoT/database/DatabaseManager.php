<?php

namespace UIoT\database;

use PDO;
use PDOStatement;
use UIoT\messages\ResourceItemAddedMessage;
use UIoT\messages\ResourceItemDeleteMessage;
use UIoT\messages\ResourceItemUpdatedMessage;
use UIoT\sql\SQLWords;
use UIoT\util\MessageHandler;

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
    public function query($query)
    {
        return static::$databaseInstance->prepare($query);
    }

    /**
     * Executes a Query
     *
     * @param PDOStatement $query
     * @param array $statements
     * @return mixed
     */
    public function execute($query, array $statements)
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
    public function fastExecute($query, array $statement)
    {
        return $this->execute($this->query($query), $statement);
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
        $this->execute($statement = $this->query($query), $statements);

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
                return 'aaaa';
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
                return $prepared->fetchAll(PDO::FETCH_OBJ);
            case SQLWords::getUpdate():
                return MessageHandler::getInstance()->getMessage(new ResourceItemUpdatedMessage);
            case SQLWords::getInsert():
                return MessageHandler::getInstance()->getMessage(new ResourceItemAddedMessage);
            case SQLWords::getDelete():
                return MessageHandler::getInstance()->getMessage(new ResourceItemDeleteMessage);
        }
    }
}
