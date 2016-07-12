<?php

namespace UIoT\sql;

use UIoT\messages\InvalidColumnNameMessage;
use UIoT\model\MetaResource;
use UIoT\model\UIoTRequest;
use UIoT\util\MessageHandler;

/**
 * Class SQLInstructionFactory
 * @package UIoT\sql
 */
class SQLInstructionFactory
{
    /**
     * @var MetaResource[] Resources
     */
    private $resources;

    /**
     * @var SQLInstruction[] Instructions
     */
    private $methods = [
        'GET' => 'UIoT\sql\SQLSelect',
        'POST' => 'UIoT\sql\SQLInsert',
        'PUT' => 'UIoT\sql\SQLUpdate',
        'DELETE' => 'UIoT\sql\SQLDelete'];

    /**
     * SQLInstructionFactory constructor.
     *
     * @param MetaResource[] $resources
     */
    public function __construct($resources)
    {
        $this->resources = $resources;
    }

    /**
     * Create an Instruction
     *
     * @param UIoTRequest $request
     * @return mixed
     */
    public function createInstruction(UIoTRequest $request)
    {
        $resource = $this->resources[$request->getResource()];
        /** @var SQLInstruction $instruction */
        $methodType = $this->methods[$request->getMethod()];
        $instruction = new $methodType;
        $instruction->setEntity($resource->getName());
        $this->addColumns($resource, $request, $instruction);
        $this->setCriteria($resource, $request, $instruction);
        return $instruction->getInstruction();
    }

    /**
     * Set a Specific Criteria
     *
     * @param MetaResource $resource
     * @param UIoTRequest $request
     * @param SQLInstruction $instruction
     */
    private function setCriteria(MetaResource $resource, UIoTRequest $request, SQLInstruction $instruction)
    {
        $values = $request->getUri()->getQuery()->getData();

        if ($instruction instanceof SQLInsert) {
            $instruction->setValues($values);
            $values = $this->removeColumnByKey('id', $values);
        }

        if ($instruction instanceof SQLUpdate) {
            $instruction->setColumnValues(['id' => $request->getUri()->query->get('id')]);
            $values = $this->removeColumnByKey('id', $values);
        }

        $instruction->setCriteria($this->getCriteria($resource, $this->removeColumnByKey('token', $values)));
    }

    /**
     * Return a criteria.
     *
     * @param MetaResource $resource
     * @param string[] $parameters
     * @return SQLCriteria
     */
    private function getCriteria(MetaResource $resource, $parameters)
    {
        $criteria = new SQLCriteria();

        foreach ($parameters as $friendlyName => $value) {
            if ($friendlyName != "token") {
                $columnName = $resource->getProperty($friendlyName);

                if (null == $columnName) {
                    MessageHandler::getInstance()->endExecution(new InvalidColumnNameMessage);
                }

                $criteria->addFilter(new SQLFilter($columnName->getPropertyName(), SQLWords::getEqualsOp(), $value), SQLWords::getAndOp());
            }
        }

        return $criteria;
    }

    /**
     * Add a set of Columns
     *
     * @param MetaResource $resource
     * @param UIoTRequest $request
     * @param SQLInstruction $instruction
     */
    private function addColumns(MetaResource $resource, UIoTRequest $request, SQLInstruction $instruction)
    {
        if ($instruction instanceof SQLSelect) {
            $instruction->addColumns($resource->getColumnNames());
        } elseif ($instruction instanceof SQLUpdate) {
            $instruction->addColumns($this->removeColumn('ID', $resource->getColumnNames()));
        } else {
            $instruction->addColumns($resource->getColumnNamesByQuery($request->getParameterColumns()));
        }
    }

    /**
     * Remove Column
     *
     * @param $columnName
     * @param $columns
     * @return mixed
     */
    private function removeColumn($columnName, $columns)
    {
        foreach ($columns as $key => $column) {
            if ($column == $columnName) {
                unset($columns[$key]);
            }
        }

        return $columns;
    }

    /**
     * Remove Column by a key
     *
     * @param $columnName
     * @param $columns
     * @return mixed
     */
    private function removeColumnByKey($columnName, $columns)
    {
        foreach ($columns as $key => $column) {
            if ($key == $columnName) {
                unset($columns[$columnName]);
            }
        }

        return $columns;
    }
}
