<?php

namespace UIoT\view;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UIoT\control\RequestController;
use UIoT\control\ResourceController;
use UIoT\model\UIoTRequest;
use UIoT\model\UIoTResponse;
use UIoT\util\ExceptionHandler;
use UIoT\validators\RequestValidator;
use UIoT\database\DatabaseExecuter;
use UIoT\database\DatabaseConnector;
use UIoT\model\MetaResource;
use UIoT\model\MetaProperty;
/**
 * Class RequestInput
 *
 * @package UIoT\view
 *
 * @property RequestController $requestControl
 * @property RequestRouter $requestRouter
 * @property UIoTRequest $requestData
 * @property Response $responseData
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

    private $requestValidator;

    private $dbExecuter;

    private $dbConnector;

    private $resourceController;

    /**
     * RequestInput constructor.
     */
    public function __construct()
    {

        $this->dbExecuter = new DatabaseExecuter();

        $this->dbConnector = new DatabaseConnector();

        self::registerExceptionHandler();

        self::setRequestController(new RequestController($this->dbExecuter));

        self::setResourceController($this->getResources());

        self::setRequestData(UIoTRequest::createFromGlobals());

        self::getRequestData()->assignRequestData();

        self::setResponseData();

        self::setRequestValidator($this->getResources());


    }

    /**
     * Register Exception Handler
     */
    private function registerExceptionHandler()
    {
        set_exception_handler(array(ExceptionHandler::getInstance(), 'handleException'));
    }

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
     * Starts the Request creation and submission process
     *
     * @return array|bool|string
     */
    public function route()
    {
        $request = $this->requestController->createRequest($this);

        try {
            if ($this->requestValidator->validate($request))
                return $this->resourceController->executeRequest($request);

        } catch(InvalidRaiseResourceException $e) {
        }

    }

    private function getResources()
    {
        $resources = array();
        $queryResult = $this->dbExecuter->execute('SELECT * FROM META_RESOURCES', $this->dbConnector->getPdoObject());
        foreach ($queryResult as $resource) {
            $resources[$resource["RSRC_FRIENDLY_NAME"]] = new MetaResource($resource["ID"], $resource["RSRC_ACRONYM"], $resource["RSRC_NAME"], $resource["RSRC_FRIENDLY_NAME"], $this->getResourceProperties($resource["ID"]));
        }
       return $resources;
    }

    private function getResourceProperties($id)
    {
        $properties = array();
        $queryResult = $this->dbExecuter->execute('SELECT * FROM META_PROPERTIES WHERE RSRC_ID =' . $id, $this->dbConnector->getPdoObject());
        foreach ($queryResult as $property) {
            $properties[$property["PROP_FRIENDLY_NAME"]] = new MetaProperty($property["ID"], $property["PROP_NAME"], $property["PROP_FRIENDLY_NAME"]);
        }
        return $properties;
    }


    private function setRequestValidator($resources)
    {
        $this->requestValidator =  new RequestValidator($resources);
    }
}