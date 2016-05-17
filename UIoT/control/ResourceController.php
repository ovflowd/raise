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
use UIoT\model\MetaProperty;
use UIoT\model\UIoTRequest;
use UIoT\model\MetaResource;
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
     * @var SQLInstructionFactory
     */
    private $factory;

    /**
     * ResourceController constructor.
     */
    public function __construct()
    {
        $this->dbExecuter = new DatabaseExecuter();
        $this->dbConnector = new DatabaseConnector();
        $this->factory = new SQLInstructionFactory($this->getResources());
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
        //$this->getResources();
        return $this->dbExecuter->execute($this->getInstruction($request->getRequestData()), $this->dbConnector->getPdoObject());
    }

    /**
     * Gets connection from dbConnector attribute.
     *
     * @return PDO
     */
    public function getConnection()
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
       return $this->factory->createInstruction($request);
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

    /**
     * @return DatabaseExecuter
     */
    public function getDbExecuter()
    {
        return $this->dbExecuter;
    }

    /**
     *
     */
    private function getResources()
    {
        $resources = array();
        $queryResult = $this->dbExecuter->execute('SELECT * FROM META_RESOURCES', $this->getConnection());
        foreach ($queryResult as $resource) {
            $resources[$resource["RSRC_FRIENDLY_NAME"]] = new MetaResource($resource["ID"], $resource["RSRC_ACRONYM"], $resource["RSRC_NAME"], $resource["RSRC_FRIENDLY_NAME"], $this->getResourceProperties($resource["ID"]));
        }
        return $resources;
    }

    /**
     *
     */
    private function getResourceProperties($id)
    {
        $properties = array();
        $queryResult = $this->dbExecuter->execute('SELECT * FROM META_PROPERTIES WHERE RSRC_ID =' . $id, $this->getConnection());
        foreach ($queryResult as $property) {
            $properties[$property["PROP_FRIENDLY_NAME"]] = new MetaProperty($property["ID"], $property["PROP_NAME"], $property["PROP_FRIENDLY_NAME"]);
        }
        return $properties;
    }
}