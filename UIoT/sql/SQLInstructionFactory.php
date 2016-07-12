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
        }

        //if ($request->getRequestValidation()->hasParameters() && !($instruction instanceof SQLInsert))
        $criteria = $this->getCriteria($resource, $values);

        if ($instruction instanceof SQLUpdate) {
            $instruction->setColumnValues(['id' => $request->getUri()->getPath()->getData()[3]]);
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
        } else {
            $instruction->addColumns($resource->getColumnNamesByQuery($request->getParameterColumns()));
        }
    }
}
