<?php

namespace UIoT\util;

use Symfony\Component\HttpFoundation\Request;
use UIoT\control\RequestController;
use UIoT\control\ResourceController;
use UIoT\database\DatabaseHandler;
use UIoT\database\DatabaseManager;
use UIoT\messages\InvalidRaiseResourceMessage;
use UIoT\model\MetaProperty;
use UIoT\model\MetaResource;
use UIoT\model\UIoTRequest;
use UIoT\model\UIoTResponse;

/**
 * Class RequestInput
 * @package UIoT\util
 */
class RequestInput
{
    /**
     * @var RequestController
     */
    private $requestController;

    /**
     * @var UIoTRequest
     */
    private $requestData;

    /**
     * @var UIoTResponse
     */
    private $responseData;

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @var DatabaseHandler
     */
    private $databaseHandler;

    /**
     * @var ResourceController
     */
    private $resourceController;

    /**
     * RequestInput constructor.
     */
    public function __construct()
    {
        $this->databaseManager = new DatabaseManager();
        $this->databaseHandler = new DatabaseHandler();

        self::registerExceptionHandler();
        self::setRequestController(new RequestController($this->databaseManager));
        self::setResourceController($this->getResources());
        self::setRequestData(UIoTRequest::createFromGlobals());
        self::getRequestData()->assignRequest();
        self::setResponseData();
    }

    /**
     * Register Exception Handler
     */
    private function registerExceptionHandler()
    {
        set_exception_handler(array(MessageHandler::getInstance(), 'getMessage'));
    }

    /**
     * @param $resources
     */
    private function setResourceController($resources)
    {
        $this->resourceController = new ResourceController($resources);
    }

    /**
     * Sets the request controller attribute | @see $requestControl
     *
     * @param RequestController $requestControl
     */
    private function setRequestController(RequestController $requestControl)
    {
        $this->requestController = $requestControl;
    }

    /**
     * Set Current Request Data
     *
     * @param Request $requestData
     */
    private function setRequestData(Request $requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * Set Response based on his Request
     *
     * @param Request $requestData
     */
    private function setResponseData(Request $requestData = NULL)
    {
        $this->responseData = new UIoTResponse();
        $this->responseData->prepare($requestData == NULL ? $this->requestData : $requestData);
    }

    /**
     * Get Request Data
     *
     * @return UIoTRequest
     */
    public function getRequestData()
    {
        return $this->requestData;
    }

    /**
     * Get Response Data
     *
     * @return UIoTResponse
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * @return mixed
     * @throws InvalidRaiseResourceMessage
     */
    public function route()
    {
        $request = $this->requestController->createRequest($this);

        if (!in_array($request->getResource(), $this->getResourceNames()))
            MessageHandler::getInstance()->endExecution(new InvalidRaiseResourceMessage);

        return $this->resourceController->executeRequest($request);
    }

    /**
     * Get friendly name from getResources array
     *
     * @return array
     */
    private function getResourceNames()
    {
        $names = [];
        foreach ($this->getResources() as $resource) {
            $names[] = $resource->getFriendlyName();
        }

        return $names;
    }

    /**
     * @return array
     */
    private function getResources()
    {
        $resources = array();

        foreach ($this->databaseManager->execute('SELECT * FROM META_RESOURCES',
            $this->databaseHandler->getInstance()) as $resource) {
            $resources[$resource->RSRC_FRIENDLY_NAME] = new MetaResource($resource->ID, $resource->RSRC_ACRONYM, $resource->RSRC_NAME, $resource->RSRC_FRIENDLY_NAME, $this->getResourceProperties($resource->ID));
        }

        return $resources;
    }

    /**
     * @param $id
     * @return array
     */
    private function getResourceProperties($id)
    {
        $properties = array();

        foreach ($this->databaseManager->execute('SELECT * FROM META_PROPERTIES WHERE RSRC_ID =' . $id,
            $this->databaseHandler->getInstance()) as $property) {
            $properties[$property->PROP_FRIENDLY_NAME] = new MetaProperty($property->ID, $property->PROP_NAME, $property->PROP_FRIENDLY_NAME);
        }

        return $properties;
    }
}