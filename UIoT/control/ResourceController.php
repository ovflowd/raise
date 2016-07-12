<?php

namespace UIoT\control;

use UIoT\messages\InvalidColumnNameMessage;
use UIoT\messages\InvalidMethodMessage;
use UIoT\model\MetaResource;
use UIoT\model\UIoTRequest;
use UIoT\sql\SQLDelete;
use UIoT\sql\SQLInsert;
use UIoT\sql\SQLInstructionFactory;
use UIoT\sql\SQLSelect;
use UIoT\sql\SQLUpdate;
use UIoT\util\RequestInput;

/**
 * Class ResourceController
 * @package UIoT\control
 */
class ResourceController
{
    /**
     * @var SQLInstructionFactory
     */
    private $factory;

    /**
     * ResourceController constructor.
     *
     * @param MetaResource[] $resources
     */
    public function __construct($resources)
    {
        $this->factory = new SQLInstructionFactory($resources);
    }

    /**
     * Execute the Request
     *
     * @param UIoTRequest $request
     * @return array|bool|int|object|string
     */
    public function executeRequest(UIoTRequest $request)
    {
        return RequestInput::getDatabaseManager()->action($this->getInstruction($request));
    }

    /**
     * Get SQL Instruction
     *
     * @param UIoTRequest $request
     * @return SQLDelete|SQLInsert|SQLSelect|SQLUpdate
     * @throws InvalidColumnNameMessage
     * @throws InvalidMethodMessage
     */
    private function getInstruction(UIoTRequest $request)
    {
        return $this->factory->createInstruction($request);
    }
}
