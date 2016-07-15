<?php

namespace UIoT\managers;

use UIoT\callbacks\ExecuteDeleteCallBack;
use UIoT\callbacks\ExecuteGetCallBack;
use UIoT\callbacks\ExecutePostCallBack;
use UIoT\callbacks\ExecutePutCallBack;
use UIoT\database\DatabaseManager;
use UIoT\messages\InvalidRaiseResourceMessage;
use UIoT\messages\WelcomeToRaiseMessage;
use UIoT\model\UIoTRequest;
use UIoT\model\UIoTResponse;
use UIoT\model\UIoTToken;
use UIoT\util\MessageHandler;

/**
 * Class RequestManager
 * @package UIoT\managers
 */
class RequestManager
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
     * @var ResourceManager
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
        $this->setResourceManager(new ResourceManager);

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
     * @param ResourceManager $resource
     */
    protected function setResourceManager(ResourceManager $resource)
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
     * Route RAISE
     *
     * @return mixed
     */
    public function route()
    {
        if ($this->getRequest()->getInstance()->getPath()->getPath() == '/') {
            return MessageHandler::getInstance()->getResult(new WelcomeToRaiseMessage);
        } elseif (!in_array($this->getRequest()->getResource(), self::getResourceManager()->getResources())) {
            return MessageHandler::getInstance()->getResult(new InvalidRaiseResourceMessage);
        }

        switch ($this->getRequest()->getMethod()) {
            case "POST":
                return ExecutePostCallBack::getCallBack($this->getRequest());
            case "PUT":
                return ExecutePutCallBack::getCallBack($this->getRequest());
            case "DELETE":
                return ExecuteDeleteCallBack::getCallBack($this->getRequest());
            default:
                return ExecuteGetCallBack::getCallBack($this->getRequest());
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
     * @return ResourceManager
     */
    public static function getResourceManager()
    {
        return self::$resourceManager;
    }
}
