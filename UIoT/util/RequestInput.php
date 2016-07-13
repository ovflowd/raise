<?php

namespace UIoT\util;

use UIoT\callbacks\ExecuteDeleteCallBack;
use UIoT\callbacks\ExecuteGetCallBack;
use UIoT\callbacks\ExecutePostCallBack;
use UIoT\callbacks\ExecutePutCallBack;
use UIoT\database\DatabaseManager;
use UIoT\messages\InvalidRaiseResourceMessage;
use UIoT\messages\WelcomeToRaiseMessage;
use UIoT\model\UIoTRequest;
use UIoT\model\UIoTResource;
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
    private static $request;

    /**
     * @var UIoTResponse
     */
    private static $response;

    /**
     * @var DatabaseManager
     */
    private static $databaseManager;

    /**
     * @var UIoTResource
     */
    private static $resourceManager;

    /**
     * @var UIoTToken
     */
    private static $tokenManager;

    /**
     * RequestInput constructor.
     */
    public function __construct()
    {

        $this->setDatabaseManager(new DatabaseManager);
        $this->setResourceManager(new UIoTResource);

        $this->setRequest()->getInstance();

        self::$tokenManager = new UIoTToken();

        $this->setResponse();
    }

    /**
     * Instantiate Database Manager
     *
     * @param DatabaseManager $databaseManager
     */
    protected function setDatabaseManager(DatabaseManager $databaseManager)
    {
        self::$databaseManager = $databaseManager;
    }

    /**
     * Set Resource Manager
     *
     * @param UIoTResource $resource
     */
    protected function setResourceManager(UIoTResource $resource)
    {
        self::$resourceManager = $resource;
    }

    /**
     * Set UIoTRequest Data
     *
     * @return UIoTRequest
     */
    protected function setRequest()
    {
        return self::$request = UIoTRequest::createFromGlobals();
    }

    /**
     * Set Response based on his Request
     */
    protected function setResponse()
    {
        return self::$response = new UIoTResponse();
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
     * Get Response Data
     *
     * @return UIoTResponse
     */
    public static function getResponse()
    {
        return self::$response;
    }

    /**
     * Route Raise
     *
     * @return mixed
     */
    public function route()
    {
        if ($this->getRequest()->getInstance()->getPath()->getPath() == '/') {
            MessageHandler::getInstance()->endExecution(new WelcomeToRaiseMessage);
        } elseif (!in_array($this->getRequest()->getResource(), self::getResourceManager()->getResources())) {
            return MessageHandler::getInstance()->getResult(new InvalidRaiseResourceMessage);
        }

        switch ($this->getRequest()->getMethod()) {
            case "POST":
                return (new ExecutePostCallBack($this->getRequest()))->getCallBack();
            case "PUT":
                return (new ExecutePutCallBack($this->getRequest()))->getCallBack();
            case "GET":
                return (new ExecuteGetCallBack($this->getRequest()))->getCallBack();
            case "DELETE":
                return (new ExecuteDeleteCallBack($this->getRequest()))->getCallBack();
            default:
                return MessageHandler::getInstance()->getResult(new InvalidRaiseResourceMessage);
        }
    }

    /**
     * Get Request Data
     *
     * @return UIoTRequest
     */
    public static function getRequest()
    {
        return self::$request;
    }

    /**
     * Get UIoT Resource Manager
     *
     * @return UIoTResource
     */
    public static function getResourceManager()
    {
        return self::$resourceManager;
    }
}
