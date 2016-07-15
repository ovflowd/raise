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
     * @var SQLInstruction[] Instructions
     */
    private $methods = [
        'GET' => 'UIoT\sql\SQLSelect',
        'POST' => 'UIoT\sql\SQLInsert',
        'PUT' => 'UIoT\sql\SQLUpdate',
        'DELETE' => 'UIoT\sql\SQLDelete'
    ];

    /**
     * @var SQLInstruction SQL Instruction
     */
    private $instruction;

    /**
     * Create an Instruction
     *
     * @param UIoTRequest $request
     * @return mixed
     */
    public function createInstruction(UIoTRequest $request)
    {
        $this->setInstruction($request);
        $this->setProperties($request);
        $this->setValues($request);
        $this->setCriteria($request);

        return $this->instruction->getInstruction();
    }

    /**
     * Create UIoT's SQLInstruction
     *
     * @param UIoTRequest $request
     */
    private function setInstruction(UIoTRequest $request)
    {
        $this->instruction = new $this->methods[$request->getMethod()];
        $this->instruction->setEntity($request->getResource()->getName());
    }

    /**
     * Add a set of Properties to Instruction
     *
     * @param UIoTRequest $request
     */
    private function setProperties(UIoTRequest $request)
    {
        if ($this->instruction instanceof SQLSelect) {
            $this->instruction->setProperties($request->getResource()->getProperties());
        } elseif ($this->instruction instanceof SQLUpdate) {
            $properties = array_diff_key($request->getInstance()->getQuery()->getData(), ['token' => '', 'id' => '']);

            $this->instruction->setProperties(array_combine($request->getResource()->getPropertiesByNames($properties),
                $properties));
        } else {
            $this->instruction->setProperties($request->getResource()->getPropertiesByNames(
                array_diff_key($request->getInstance()->getQuery()->getData(), ['token' => '', 'id' => ''])));
        }
    }

    /**
     * Add a set of Values to Instruction
     *
     * @param UIoTRequest $request
     */
    private function setValues(UIoTRequest $request)
    {
        if ($this->instruction instanceof SQLInsert) {
            $this->instruction->setValues(array_diff_key($request->getInstance()->getQuery()->getData(),
                ['token' => '', 'id' => '']));
        }
    }

    /**
     * Set a set of Criteria's to Instruction
     *
     * @param UIoTRequest $request
     */
    private function setCriteria(UIoTRequest $request)
    {
        if ($this->instruction instanceof SQLInsert) {
            $criteria = array_diff_key($request->getInstance()->getQuery()->getData(), ['token' => '', 'id' => '']);
        } elseif ($this->instruction instanceof SQLUpdate) {
            $criteria = ['id' => $request->getInstance()->getQuery()->get('id')];
        } else {
            $criteria = array_diff_key($request->getInstance()->getQuery()->getData(), ['token' => '']);
        }

        $this->instruction->setCriteria($this->getCriteria($request->getResource(), $criteria));
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
            if (null == $resource->getProperty($name)) {
                MessageHandler::getInstance()->endExecution(new InvalidColumnNameMessage($name));
            }

            $criteria->addFilter(new SQLFilter($resource->getProperty($name)->getName(), SQLWords::getEqualsOp(),
                $value), SQLWords::getAndOp());
        }

        return $criteria;
    }
}
