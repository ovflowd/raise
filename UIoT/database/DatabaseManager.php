<?php

namespace UIoT\database;

use PDO;
use UIoT\messages\ResourceItemAddedMessage;
use UIoT\messages\ResourceItemDeleteMessage;
use UIoT\messages\ResourceItemUpdatedMessage;
use UIoT\sql\SQL;
use UIoT\util\MessageHandler;

/**
 * Class DatabaseManager
 * @package UIoT\database
 */
class DatabaseManager
{
    /**
     * Executes a query.
     *
     * @param string $query
     * @param PDO $connection
     * @return array|bool|int|object|string
     */
    public function execute($query, PDO $connection)
    {
        switch (substr($query, 0, 6)) {
            default:
            case SQL::SELECT:
                return $connection->query($query)->fetchAll(PDO::FETCH_OBJ);
            case SQL::UPDATE:
                return MessageHandler::getInstance()->getMessage(new ResourceItemUpdatedMessage);
            case SQL::INSERT_INTO:
            case SQL::INSERT:
                return MessageHandler::getInstance()->getMessage(new ResourceItemAddedMessage);
            case SQL::DELETE:
                return MessageHandler::getInstance()->getMessage(new ResourceItemDeleteMessage);
        }
    }
}
