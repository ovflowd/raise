<?php

namespace UIoT\database;

use PDO;
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
     * Executes a query.
     *
     * @param string $query
     * @param PDO $connection
     * @return array|bool|int|object|string
     */
    public function execute($query, PDO $connection)
    {
        $result = $connection->query($query);

        switch (substr($query, 0, 6)) {
            default:
            case SQLWords::SELECT:
                return $result->fetchAll(PDO::FETCH_OBJ);
            case SQLWords::UPDATE:
                return MessageHandler::getInstance()->getMessage(new ResourceItemUpdatedMessage);
            case SQLWords::INSERT_INTO:
            case SQLWords::INSERT:
                return MessageHandler::getInstance()->getMessage(new ResourceItemAddedMessage);
            case SQLWords::DELETE:
                return MessageHandler::getInstance()->getMessage(new ResourceItemDeleteMessage);
        }
    }
}
