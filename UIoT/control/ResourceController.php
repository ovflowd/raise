<?php

namespace UIoT\control;

use PDO;
use UIoT\database\DatabaseConnector;
use UIoT\database\DatabaseExecuter;
use UIoT\exceptions\InvalidSqlOperatorException;
use UIoT\exceptions\NotSqlFilterException;
use UIoT\model\Request;
use UIoT\exceptions\InvalidColumnNameException;
use UIoT\exceptions\InvalidMethodException;
use UIoT\sql\SQLDelete;
use UIoT\sql\SQLInsert;
use UIoT\sql\SQLSelect;
use UIoT\sql\SQLUpdate;
use UIoT\sql\SQLCriteria;
use UIoT\sql\SQLFilter;
use UIoT\sql\SQL;

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
     * @param Request $request
     * @return bool|string[]
     */
    public function executeRequest(Request $request)
    {
        $resource = $this->executeResource($request);
        return $this->dbExecuter->execute($resource->getInstruction(), $this->dbConnector->getPdoObject());
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
     * @param Request $request
     * @return SQLDelete|SQLInsert|SQLSelect|SQLUpdate
     * @throws InvalidColumnNameException
     * @throws InvalidMethodException
     */
    private function executeResource(Request $request)
    {
        $id = $this->getResourceId($request->getResource());
        $tableName = $this->getResourceTableName($request->getResource());
        $instruction = $this->getResourceInstruction($request->getMethod());
        $columns = $this->getColumnNames($id);

        if (!empty($request->getParameters()))
            $criteria = $this->getCriteria($id, $request->getParameters());
        else
            $criteria = new SQLCriteria();

        if ($instruction instanceof SQLSelect)
            $instruction->addColumns($columns);

        $instruction->setCriteria($criteria);
        $instruction->setEntity($tableName);

        return $instruction;
    }

    /**
     * Gets a resource's table name.
     * 
     * @param Resource $resource
     * @return string
     * @throws InvalidSqlOperatorException
     * @throws NotSqlFilterException
     */
    private function getResourceTableName($resource)
    {
        $instruction = new SQLSelect();
        $criteria = new SQLCriteria();
        $criteria->addFilter(new SQLFilter('RSRC_FRIENDLY_NAME', SQL::EQUALS_OP(), $resource), SQL::AND_OP());
        $instruction->setCriteria($criteria);
        $instruction->addColumn('RSRC_NAME');
        $instruction->setEntity('META_RESOURCES');

        return $this->dbExecuter->execute($instruction->getInstruction(), $this->getConnection())[0]['RSRC_NAME'];
    }

    /**
     * Gets a a resource's SQL Instruction (GET, POST, PUT or DELETE).
     *
     * @param string $method
     * @return SQLDelete|SQLInsert|SQLSelect|SQLUpdate
     * @throws InvalidMethodException
     */
    private function getResourceInstruction($method)
    {
        switch ($method) {
            case 'GET':
                return new SQLSelect();
            case 'POST':
                return new SQLInsert();
            case 'PUT':
                return new SQLUpdate();
            case 'DELETE':
                return new SQLDelete();
            default:
                throw new InvalidMethodException("Http method not supported");
        }
    }

    /**
     * Gets a resource's column names.
     *
     * @param int $id
     * @return string[]
     * @throws InvalidSqlOperatorException
     * @throws NotSqlFilterException
     */
    private function getColumnNames($id)
    {
        $instruction = new SQLSelect();
        $criteria = new SQLCriteria();
        $criteria->addFilter(new SQLFilter('RSRC_ID', SQL::EQUALS_OP(), $id), SQL::AND_OP());
        $instruction->setCriteria($criteria);
        $instruction->addColumn('PROP_NAME');
        $instruction->setEntity('META_PROPERTIES');

        return $this->extractColumnNames($this->dbExecuter->execute($instruction->getInstruction(), $this->getConnection()));
    }

    /**
     *  Gets a resource's ID.
     *
     * @param string $resourceName
     * @return string|bool
     * @throws InvalidSqlOperatorException
     * @throws NotSqlFilterException
     */
    private function getResourceId($resourceName)
    {
        $instruction = new SQLSelect();
        $criteria = new SQLCriteria();
        $criteria->addFilter(new SQLFilter('RSRC_FRIENDLY_NAME', SQL::EQUALS_OP(), $resourceName), SQL::AND_OP());
        $instruction->setCriteria($criteria);
        $instruction->addColumn('ID');
        $instruction->setEntity('META_RESOURCES');

        return $this->dbExecuter->execute($instruction->getInstruction(), $this->getConnection())[0]['ID'];
    }

    /**
     * Gets a column's name.
     *
     * @param int $id
     * @param string $friendlyName
     * @return string|bool
     * @throws InvalidSqlOperatorException
     * @throws NotSqlFilterException
     */
    private function getColumnName($id, $friendlyName)
    {

        $instruction = new SQLSelect();
        $criteria = new SQLCriteria();
        $criteria->addFilter(new SQLFilter('PROP_FRIENDLY_NAME', SQL::EQUALS_OP(), $friendlyName), SQL::AND_OP());
        $criteria->addFilter(new SQLFilter('RSRC_ID', SQL::EQUALS_OP(), $id), SQL::AND_OP());
        $instruction->setCriteria($criteria);
        $instruction->addColumn('PROP_NAME');
        $instruction->setEntity('META_PROPERTIES');

        return $this->dbExecuter->execute($instruction->getInstruction(), $this->getConnection());
    }

    /**
     * Gets a criteria.
     *
     * @param int $id
     * @param string[] $parameters
     * @return SQLCriteria
     * @throws InvalidColumnNameException
     * @throws InvalidSqlOperatorException
     * @throws NotSqlFilterException
     */
    private function getCriteria($id, $parameters)
    {
        $criteria = new SQLCriteria();
        foreach ($parameters as $key => $value) {
            $column = $this->getColumnName($id, $key);
            if (is_null($column))
                throw new InvalidColumnNameException();

            $filter = new SQLFilter($column[0]['PROP_NAME'], SQL::EQUALS_OP(), $value);
            $criteria->addFilter($filter, SQL::AND_OP());
        }

        return $criteria;
    }

    /**
     * Gets a the names of all columns in an array.
     *
     * @param string[] $rawColumnsArray
     * @return string[]
     */
    private function extractColumnNames($rawColumnsArray)
    {
        $columns = array();
        foreach ($rawColumnsArray as $key => $columnNameArray) {
            foreach ($columnNameArray as $columnName)
                $columns[] = $columnName;
        }
        return $columns;
    }
}