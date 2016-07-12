<?php

namespace UIoT\util;

use Symfony\Component\HttpFoundation\Request;
use UIoT\callbacks\ExecuteGetCallBack;
use UIoT\callbacks\ExecutePostCallBack;
use UIoT\callbacks\ExecutePutCallBack;
use UIoT\control\ResourceController;
use UIoT\database\DatabaseManager;
use UIoT\messages\InvalidRaiseResourceMessage;
use UIoT\model\MetaProperty;
use UIoT\model\MetaResource;
use UIoT\model\UIoTRequest;
use UIoT\model\UIoTResponse;
use UIoT\model\UIoTToken;

/**
 * Class RequestInput
 * @package UIoT\util
 */
class RequestInput
{
    /**
     * @var UIoTRequest
     */
    private static $requestData;

    /**
     * @var UIoTResponse
     */
    private static $responseData;

    /**
     * @var DatabaseManager
     */
    private static $databaseManager;

    /**
     * @var ResourceController
     */
    private static $resourceController;

    /**
     * @var UIoTToken
     */
    private static $tokenManager;

    /**
     * RequestInput constructor.
     */
    public function __construct()
    {
        self::$databaseManager = new DatabaseManager();
        self::$resourceController = new ResourceController(self::getResources());
        self::$tokenManager = new UIoTToken();
        self::$requestData = UIoTRequest::createFromGlobals();

        $this->getRequestData()->assignRequest();
        $this->setResponseData();
    }

    /**
     * Get Token Manager
     *
     * @return UIoTToken
     */
    public static function getTokenManager()
    {
        return self::$tokenManager;
    }

    /**
     * Get Database Manager
     *
     * @return DatabaseManager
     */
    public static function getDatabaseManager()
    {
        return self::$databaseManager;
    }

    /**
     * Get Resource Controller
     *
     * @return ResourceController
     */
    public static function getResourceController()
    {
        return self::$resourceController;
    }

    /**
     * Set Response based on his Request
     *
     * @param Request $requestData
     */
    private function setResponseData(Request $requestData = null)
    {
        self::$responseData = new UIoTResponse();
        self::$responseData->prepare($requestData == null ? self::$requestData : $requestData);
    }

    /**
     * Get Request Data
     *
     * @return UIoTRequest
     */
    public function getRequestData()
    {
        return self::$requestData;
    }

    /**
     * Get Response Data
     *
     * @return UIoTResponse
     */
    public function getResponseData()
    {
        return self::$responseData;
    }

    /**
     * Route Raise
     *
     * @return mixed
     */
    public function route()
    {
        $request = $this->getRequestData();

        if (!in_array($request->getResource(), $this->getResourceNames())) {
            return MessageHandler::getInstance()->getResult(new InvalidRaiseResourceMessage);
        }

        switch ($request->getMethod()) {
            case "POST":
                return (new ExecutePostCallBack($request))->getCallBack();
            case "PUT":
                return (new ExecutePutCallBack($request))->getCallBack();
            case "GET":
                return (new ExecuteGetCallBack($request))->getCallBack();
            default:
                return MessageHandler::getInstance()->getResult(new InvalidRaiseResourceMessage);
        }
    }

    /**
     * Get friendly name from getResources array
     *
     * @return array
     */
    public function getResourceNames()
    {
        $names = [];

        foreach ($this->getResources() as $resource) {
            /** @var $resource MetaResource */
            $names[] = $resource->getFriendlyName();
        }

        return $names;
    }

    /**
     * Get Resources
     *
     * @return MetaResource[]
     */
    public static function getResources()
    {
        $resources = array();

        foreach (self::$databaseManager->action('SELECT * FROM META_RESOURCES') as $resource) {
            $resources[$resource->RSRC_FRIENDLY_NAME] = new MetaResource($resource->ID, $resource->RSRC_ACRONYM,
                $resource->RSRC_NAME, $resource->RSRC_FRIENDLY_NAME, self::getResourceProperties($resource->ID));
        }

        return $resources;
    }

    /**
     * Get Resource Properties
     *
     * @param integer $resourceId
     * @return MetaProperty[]
     */
    public static function getResourceProperties($resourceId)
    {
        $properties = array();

        foreach (self::$databaseManager->action('SELECT * FROM META_PROPERTIES WHERE RSRC_ID = :resource_id', [':resource_id' => $resourceId]) as $property) {
            $properties[$property->PROP_FRIENDLY_NAME] = new MetaProperty($property->ID,
                $property->PROP_NAME, $property->PROP_FRIENDLY_NAME);
        }

        return $properties;
    }
}
