<?php

namespace UIoT\sql;

use UIoT\messages\InvalidColumnNameMessage;
use UIoT\model\MetaProperty;
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
     * @var SQLInstruction[] Instructions
     */
    private $methods = [
        'GET' => 'UIoT\sql\SQLSelect',
        'POST' => 'UIoT\sql\SQLInsert',
        'PUT' => 'UIoT\sql\SQLUpdate',
        'DELETE' => 'UIoT\sql\SQLDelete'
    ];

    /**
     * Create an Instruction
     *
     * @param UIoTRequest $request
     * @return mixed
     */
    public function createInstruction(UIoTRequest $request)
    {
        $resource = $request->getResource();
        /** @var SQLInstruction $instruction */
        $methodType = $this->methods[$request->getMethod()];
        $instruction = new $methodType;
        $instruction->setEntity($resource->getName());
        $this->setProperties($resource, $request, $instruction);
        $this->setCriteria($resource, $request, $instruction);
        return $instruction->getInstruction();
    }

    /**
     * Add a set of Columns
     *
     * @param MetaResource $resource
     * @param UIoTRequest $request
     * @param SQLInstruction $instruction
     */
    private function setProperties(MetaResource $resource, UIoTRequest $request, SQLInstruction $instruction)
    {
        if ($instruction instanceof SQLSelect) {
            $instruction->setProperties($resource->getProperties());
        } elseif ($instruction instanceof SQLInsert || $instruction instanceof SQLUpdate) {
            $instruction->setProperties($this->removeProperty('id',
                $resource->getPropertiesByNames($request->getInstance()->getQuery()->getData())));
        } else {
            $instruction->setProperties($resource->getPropertiesByNames($request->getInstance()->getQuery()->getData()));
        }
    }

    /**
     * Remove a specific Property from Properties Array
     *
     * @param string $propertyName
     * @param MetaProperty[] $properties
     * @return array
     */
    private function removeProperty($propertyName, $properties)
    {
        return array_filter($properties, function ($property) use ($propertyName) {
            /** @var $property MetaProperty */
            return strcasecmp($property->getFriendlyName(), $propertyName) !== 0;
        });
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
        $columns = $request->getInstance()->getQuery()->getData();
        $columns = $this->removeColumnByKey('token', $columns);

        if ($instruction instanceof SQLInsert) {
            $columns = $this->removeColumnByKey('id', $columns);
            $instruction->setValues($columns);
            $criteria = $this->getCriteria($resource, $columns);
        } elseif ($instruction instanceof SQLUpdate) {
            $criteria = $this->getCriteria($resource, ['id' => $request->getInstance()->getQuery()->get('id')]);
        } else {
            $criteria = $this->getCriteria($resource, $columns);
        }

        $instruction->setCriteria($criteria);
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

            $criteria->addFilter(new SQLFilter($metaProperty->getName(), SQLWords::getEqualsOp(), $value),
                SQLWords::getAndOp());
        }

        return $criteria;
    }
}
