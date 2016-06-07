<?php

namespace UIoT\control;

use PDO;
use UIoT\database\DatabaseHandler;
use UIoT\database\DatabaseManager;
use UIoT\messages\InvalidColumnNameMessage;
use UIoT\messages\InvalidMethodMessage;
use UIoT\model\MetaResource;
use UIoT\model\UIoTRequest;
use UIoT\sql\SQLDelete;
use UIoT\sql\SQLInsert;
use UIoT\sql\SQLInstructionFactory;
use UIoT\sql\SQLSelect;
use UIoT\sql\SQLUpdate;

/**
 * Class ResourceController
 * @package UIoT\control
 */
class ResourceController
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @var SQLInstructionFactory
     */
    private $factory;

    /**
     * ResourceController constructor.
     *
     * @param MetaResource[] $resources
     */
    public function __construct($resources)
    {
        $this->databaseManager = new DatabaseManager();
        $this->databaseInstance = new DatabaseHandler();
        $this->factory = new SQLInstructionFactory($resources);
    }

    /**
     * Gets connection from dbConnector attribute.
     *
     * @return PDO
     */
    public function getConnection()
    {
        return $this->databaseInstance->getInstance();
    }

    /**
     * Get SQL Instruction
     *
     * @param UIoTRequest $request
     * @return SQLDelete|SQLInsert|SQLSelect|SQLUpdate
     * @throws InvalidColumnNameMessage
     * @throws InvalidMethodMessage
     */
    private function getInstruction(UIoTRequest $request)
    {
        return $this->factory->createInstruction($request);
    }

    /**
     * Execute the Request
     *
     * @param UIoTRequest $request
     * @return array|bool|int|object|string
     * @throws \UIoT\messages\DatabaseConnectionFailedMessage
     * @throws \UIoT\messages\EmptyOrNullRowDataValueMessage
     */
    public function executeRequest(UIoTRequest $request)
    {
        return $this->databaseManager->execute($this->getInstruction($request),
            $this->databaseInstance->getInstance());
    }

    /**
     * Get Database Manager
     *
     * @return DatabaseManager
     */
    public function getDatabaseManager()
    {
        return $this->databaseManager;
    }
}