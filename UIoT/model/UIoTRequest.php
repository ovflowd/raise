<?php

namespace UIoT\model;

use Purl\Url;
use Symfony\Component\HttpFoundation\Request;
use UIoT\sql\SQLInstruction;
use UIoT\sql\SQLInstructionFactory;
use UIoT\util\RequestInput;

/**
 * Class UIoTRequest
 * @package UIoT\model
 */
class UIoTRequest extends Request
{
    /**
     * @var Url RAISE Request
     */
    protected $requestUri;

    /**
     * @var SQLInstructionFactory UIoT SQL Factory
     */
    protected $factory;

    /**
     * Creates a UIoTRequest by Global Headers and Parameters
     *
     * @return UIoTRequest|Request
     */
    public static function createFromGlobals()
    {
        return parent::createFromGlobals();
    }

    /**
     * Execute the Request
     *
     * @return mixed
     */
    public function executeRequest()
    {
        return RequestInput::getDatabaseManager()->action($this->getInstruction());
    }

    /**
     * Get SQL Instruction
     *
     * @return SQLInstruction
     */
    private function getInstruction()
    {
        return $this->factory->createInstruction($this);
    }

    /**
     * Gets the resource attribute. | @see $resource
     *
     * @return MetaResource
     */
    public function getResource()
    {
        if (array_key_exists($this->getInstance()->getPath()->getData()[1],
            RequestInput::getResourceManager()->getResources())) {
            return RequestInput::getResourceManager()->getResources()[$this->getInstance()->getPath()->getData()[1]];
        }

        return null;
    }

    /**
     * Get UIoTRequest Instance
     *
     * @return Url
     */
    public function getInstance()
    {
        if (null === $this->requestUri) {
            $this->requestUri = new Url($this->getHttpHost() . '/' . basename($this->getRequestUri()));
            $this->factory = new SQLInstructionFactory();
        }

        return $this->requestUri;
    }
}
