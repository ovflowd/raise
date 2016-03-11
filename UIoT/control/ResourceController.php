<?php

namespace UIoT\control;

use PDO;
use UIoT\database\DatabaseConnector;
use UIoT\database\DatabaseExecuter;
use UIoT\exceptions\InvalidColumnNameException;
use UIoT\exceptions\InvalidMethodException;
use UIoT\exceptions\InvalidSqlOperatorException;
use UIoT\exceptions\NotSqlFilterException;
use UIoT\metadata\Metadata;
use UIoT\metadata\Resources;
use UIoT\metadata\Properties;
use UIoT\model\UIoTProperty;
use UIoT\model\UIoTRequest;
use UIoT\model\UIoTResource;
use UIoT\sql\SQL;
use UIoT\sql\SQLCriteria;
use UIoT\sql\SQLDelete;
use UIoT\sql\SQLFilter;
use UIoT\sql\SQLInsert;
use UIoT\sql\SQLInstructionFactory;
use UIoT\sql\SQLSelect;
use UIoT\sql\SQLUpdate;
use UIoT\util\ExceptionHandler;
use UIoT\view\RequestInput;

/**
 * Class ResourceController
 *
 * @package UIoT\control
 * @property DatabaseConnector $dbConnector
 * @property DatabaseExecuter $dbExecuter
 */
class ResourceController
{
    /**
     * @var DatabaseConnector
     */
    private $dbConnector;

    /**
     * @var DatabaseExecuter
     */
    private $dbExecuter;

    /**
     * ResourceController constructor.
     */
    public function __construct()
    {
        self::createDbExecuter();
        self::createDbConnector();
    }

    /**
     * Creates a new DatabaseExecuter.
     */
    private function createDbExecuter()
    {
        $this->dbExecuter = new DatabaseExecuter();
    }

    /**
     * Creates a new DatabaseConnector
     */
    private function createDbConnector()
    {
        $this->dbConnector = new DatabaseConnector();
    }

    /**
     * Executes a request.
     *
     * @param RequestInput $request
     * @return bool|string[]
     */
    public function executeRequest(RequestInput $request)
    {
        if (ExceptionHandler::getInstance()->getRaiseMessage() !== null)
            return ExceptionHandler::getInstance()->show();

        return $this->dbExecuter->execute($this->getInstruction($request->getRequestData()), $this->dbConnector->getPdoObject());
    }

    /**
     * Gets connection from dbConnector attribute.
     *
     * @return PDO
     */
    private function getConnection()
    {
        return $this->dbConnector->getPdoObject();
    }

    /**
     * Executes a resource.
     *
     * @param UIoTRequest $request
     * @return SQLDelete|SQLInsert|SQLSelect|SQLUpdate
     * @throws InvalidColumnNameException
     * @throws InvalidMethodException
     */
    private function getInstruction(UIoTRequest $request)
    {
       $factory = new SQLInstructionFactory();
       return $factory->createInstruction($this->getResourceInfo($request->getResource()), $request);
    }


    /**
     * @param string
     *
     * @return UIoTResource
     */
    private function getResourceInfo($friendlyName)
    {
        $instruction = new SQLSelect();
        $instruction->addColumns([Resources::ID(), Resources::RSRC_ACRONYM(), Resources::RSRC_NAME()]);
        $instruction->setEntity(Metadata::META_RESOURCES());
        $instruction->setCriteria($this->addCriteriaFilter(new SQLCriteria(), new SQLFilter(Resources::RSRC_FRIENDLY_NAME(), SQL::EQUALS_OP(), $friendlyName), SQL::AND_OP()));

        $result = current($this->dbExecuter->execute($instruction->getInstruction(), $this->getConnection()));
        $resource = new UIoTResource($result[Resources::ID()], $result[Resources::RSRC_ACRONYM()], $result[Resources::RSRC_NAME()], $friendlyName);
        $this->getResourceProperties($resource);
        return $resource;
    }

    /**
     * @param UIoTResource $resource
     *
     */
    private function getResourceProperties(UIoTResource $resource)
    {
        $instruction = new SQLSelect();
        $instruction->addColumns([Properties::PROP_ID(), Properties::PROP_NAME(), Properties::PROP_FRIENDLY_NAME()]);
        $instruction->setEntity(Metadata::META_PROPERTIES());
        $instruction->setCriteria($this->addCriteriaFilter(new SQLCriteria(), new SQLFilter(Properties::RSRC_ID(), SQL::EQUALS_OP(), $resource->getId()), SQL::AND_OP()));

        $resource->addProperties($this->parseProperties(($this->dbExecuter->execute($instruction->getInstruction(), $this->getConnection()))));
    }

    /**
     * @param array $rawProperties
     * @return UIoTProperty[]
     */
    private function parseProperties($rawProperties)
    {
        $properties = array();
        foreach ($rawProperties as $rawProperty)
            $properties[] = new UIoTProperty($rawProperty[Properties::PROP_ID()], $rawProperty[Properties::PROP_NAME()], $rawProperty[Properties::PROP_FRIENDLY_NAME()]);
        return $properties;
    }

    /**
     * @param SQLCriteria $criteria
     * @param SQLFilter $filter
     * @param $logicOperator
     * @return SQLCriteria
     * @throws InvalidSqlOperatorException
     * @throws NotSqlFilterException
     */
    private function addCriteriaFilter(SQLCriteria $criteria, SQLFilter $filter, $logicOperator)
    {
        $criteria->addFilter($filter, $logicOperator);
        return $criteria;
    }
}