<?php

/**
 * UIoT Service Layer
 * @version alpha
 *                          88
 *                          ""              ,d
 *                                          88
 *              88       88 88  ,adPPYba, MM88MMM
 *              88       88 88 a8"     "8a  88
 *              88       88 88 8b       d8  88
 *              "8a,   ,a88 88 "8a,   ,a8"  88,
 *               `"YbbdP'Y8 88  `"YbbdP"'   "Y888
 *
 * @author Universal Internet of Things
 * @license MIT <https://opensource.org/licenses/MIT>
 * @copyright University of Brasília
 */

namespace UIoT\Managers;

use Symfony\Component\HttpFoundation\Request;
use UIoT\Factories\InstructionFactory;
use UIoT\Factories\InteractionFactory;
use UIoT\Factories\MessageFactory;
use UIoT\Factories\ResourceFactory;
use UIoT\Handlers\RequestHandler;
use UIoT\Handlers\ResponseHandler;

/**
 * Class RaiseManager
 * @package UIoT\Managers
 */
class RaiseManager
{
    /**
     * @var RequestHandler
     */
    private $requestHandler;

    /**
     * @var ResponseHandler
     */
    private $responseHandler;

    /**
     * @var ResourceFactory
     */
    private $resourceFactory;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var InstructionFactory
     */
    private $instructionFactory;

    /**
     * @var InteractionFactory
     */
    private $interactionFactory;

    /**
     * Instantiate all RAISe Components
     */
    public function __construct()
    {
        $this->setRequestHandler(RequestHandler::createFromGlobals());
        $this->setResourceFactory(new ResourceFactory);
        $this->setMessageFactory(new MessageFactory);
        $this->setInstructionFactory(new InstructionFactory);
        $this->setInteractionFactory(new InteractionFactory);
    }

    /**
     * @return RequestHandler
     */
    public function getRequestHandler()
    {
        return $this->requestHandler;
    }

    /**
     * @param RequestHandler|Request $requestHandler
     * @return RaiseManager
     */
    public function setRequestHandler($requestHandler)
    {
        $this->requestHandler = $requestHandler;

        return $this;
    }

    /**
     * @return ResponseHandler
     */
    public function getResponseHandler()
    {
        return $this->responseHandler;
    }

    /**
     * @param ResponseHandler $responseHandler
     * @return RaiseManager
     */
    public function setResponseHandler($responseHandler)
    {
        $this->responseHandler = $responseHandler;

        return $this;
    }

    /**
     * @return ResourceFactory
     */
    public function getResourceFactory()
    {
        return $this->resourceFactory;
    }

    /**
     * @param ResourceFactory $resourceFactory
     * @return RaiseManager
     */
    public function setResourceFactory($resourceFactory)
    {
        $this->resourceFactory = $resourceFactory;

        return $this;
    }

    /**
     * @return MessageFactory
     */
    public function getMessageFactory()
    {
        return $this->messageFactory;
    }

    /**
     * @param MessageFactory $messageFactory
     * @return RaiseManager
     */
    public function setMessageFactory($messageFactory)
    {
        $this->messageFactory = $messageFactory;

        return $this;
    }

    /**
     * @return InstructionFactory
     */
    public function getInstructionFactory()
    {
        return $this->instructionFactory;
    }

    /**
     * @param InstructionFactory $instructionFactory
     * @return RaiseManager
     */
    public function setInstructionFactory($instructionFactory)
    {
        $this->instructionFactory = $instructionFactory;

        return $this;
    }

    /**
     * @return InteractionFactory
     */
    public function getInteractionFactory()
    {
        return $this->interactionFactory;
    }

    /**
     * @param InteractionFactory $interactionFactory
     * @return RaiseManager
     */
    public function setInteractionFactory($interactionFactory)
    {
        $this->interactionFactory = $interactionFactory;

        return $this;
    }
}
