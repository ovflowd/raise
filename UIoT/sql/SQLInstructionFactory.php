<?php

namespace UIoT\sql;

use UIoT\exceptions\InvalidColumnNameException;
use UIoT\model\UIoTRequest;
use UIoT\model\UIoTResource;
use UIoT\metadata\Properties;


/**
 * Class SQLInstructionFactory
 * @package UIoT\sql
 */
class SQLInstructionFactory
{
    /**
     * @var array
     */
    private $methods;

    public function __construct()
    {
        $this->methods = array(
            'GET'    => 'UIoT\sql\SQLSelect',
            'POST'   => 'UIoT\sql\SQLInsert',
            'PUT'    => 'UIoT\sql\SQLUpdate',
            'DELETE' => 'UIoT\sql\SQLDelete',
        );
    }

    /**
     * @param UIoTResource $resource
     * @param UIoTRequest $request
     */
    public function createInstruction(UIoTResource $resource, UIoTRequest $request)
    {
        $instruction = new $this->methods[$request->getMethod()];
        $instruction->setEntity($resource->getName());
        $this->addColumns($resource,$instruction);
        $this->setCriteria($resource, $request, $instruction);
        return $instruction->getInstruction();

    }

    private function setCriteria(UIoTResource $resource, UIoTRequest $request, SQLInstruction $instruction)
    {
        $criteria = new SQLCriteria();

        if ($request->getRequestValidation()->hasParameters() && !($instruction instanceof SQLInsert))
        {
            $criteria = $this->getCriteria($resource, $request->getRequestUriData()->getQuery()->getData());
        }

        $instruction->setCriteria($criteria);
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
    private function getCriteria(UIoTResource $resource, $parameters)
    {
        $criteria = new SQLCriteria();

        foreach ($parameters as $friendlyName => $value) {

            $columnName = $resource->getProperty($friendlyName)->getName();

            if (is_null($columnName))
                throw new InvalidColumnNameException();

            $filter = new SQLFilter($columnName, SQL::EQUALS_OP(), $value);

            $criteria->addFilter($filter, SQL::AND_OP());
        }

        return $criteria;
    }

    private function addColumns(UIoTResource $resource, SQLInstruction $instruction) {

        if ($instruction instanceof SQLSelect)
        {
            $instruction->addColumns($resource->getColumnNames());
        }
    }

    private function getColumnName($id, $key) {

    }


}