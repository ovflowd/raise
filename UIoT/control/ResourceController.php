<?php

namespace UIoT\control;

use PDO;
use UIoT\database\DatabaseConnector;
use UIoT\database\DatabaseExecuter;
use UIoT\exceptions\InvalidColumnNameException;
use UIoT\exceptions\InvalidMethodException;
use UIoT\exceptions\InvalidSqlOperatorException;
use UIoT\exceptions\NotSqlFilterException;
use UIoT\model\UIoTRequest;
use UIoT\model\MetaResource;
use UIoT\sql\SQLCriteria;
use UIoT\sql\SQLDelete;
use UIoT\sql\SQLFilter;
use UIoT\sql\SQLInsert;
use UIoT\sql\SQLInstructionFactory;
use UIoT\sql\SQLSelect;
use UIoT\sql\SQLUpdate;


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
     * @param MetaResource[] $resources
     */
    public function __construct($resources)
    {
        $this->dbExecuter = new DatabaseExecuter();
        $this->dbConnector = new DatabaseConnector();
        $this->factory = new SQLInstructionFactory($resources);
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

    public function executeRequest(UIoTRequest $request)
    {
        return $this->dbExecuter->execute($this->getInstruction($request), $this->dbConnector->getPdoObject());
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

}