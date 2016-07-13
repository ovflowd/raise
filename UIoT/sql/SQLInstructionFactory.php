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
        $this->setColumns($resource, $request, $instruction);
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
        $columns = $request->getUri()->getQuery()->getData();
        $columns = $this->removeColumnByKey('token', $columns);
        $criteria = $this->getCriteria($resource, $columns);

        if ($instruction instanceof SQLInsert) {
            $columns = $this->removeColumnByKey('id', $columns);
            $instruction->setValues($columns);
            $criteria = $this->getCriteria($resource, $columns);
        } elseif ($instruction instanceof SQLUpdate) {
            $criteria = $this->getCriteria($resource, ['id' => $request->getUri()->getQuery()->get('id')]);
        } elseif ($instruction instanceof SQLSelect) {
            $criteria = $this->getCriteria($resource, $columns);
        } elseif ($instruction instanceof SQLDelete) {
            $criteria = $this->getCriteria($resource, $columns);
        }

        $instruction->setCriteria($criteria);
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

        foreach ($parameters as $name => $value) {
            $metaProperty = $resource->getProperty($name);

            if (null == $metaProperty) {
                MessageHandler::getInstance()->endExecution(new InvalidColumnNameMessage($name));
            }

            $criteria->addFilter(new SQLFilter($metaProperty->getPropertyName(), SQLWords::getEqualsOp(), $value), SQLWords::getAndOp());
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
    private function setColumns(MetaResource $resource, UIoTRequest $request, SQLInstruction $instruction)
    {
        if ($instruction instanceof SQLSelect) {
            $instruction->setColumns($resource->getPropertiesNames());
        } elseif ($instruction instanceof SQLUpdate) {
            $instruction->setColumns($this->removeColumn('ID',
                $resource->getColumnNamesByQuery($request->getParameterColumns())));
        } elseif ($instruction instanceof SQLInsert) {
            $instruction->setColumns($this->removeColumn('ID',
                $resource->getColumnNamesByQuery($request->getParameterColumns())));
        } else {
            $instruction->setColumns($resource->getColumnNamesByQuery($request->getParameterColumns()));
        }
    }

    /**
     * Remove Column
     *
     * @param $columnName
     * @param $columns
     * @return array
     */
    private function removeColumn($columnName, $columns)
    {
        return array_filter($columns, function ($column) use ($columnName) {
            return strcasecmp($column, $columnName) !== 0;
        });
    }

    /**
     * Remove Column by a key
     *
     * @param $columnName
     * @param $columns
     * @return array
     */
    private function removeColumnByKey($columnName, $columns)
    {
        return array_diff_key($columns, [$columnName => '']);
    }
}
