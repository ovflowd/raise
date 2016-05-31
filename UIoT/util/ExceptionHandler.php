<?php

namespace UIoT\util;

use Exception;
use UIoT\interfaces\RaiseException;
use UIoT\model\HTTPStatus;
use UIoT\model\UIoTSingleton;

/**
 * Class ExceptionHandler
 * @package UIoT\util
 */
class ExceptionHandler extends UIoTSingleton
{
    /**
     * Raise Error Code Message
     *
     * @var HTTPStatus
     */
    protected $raiseMessage;

    /**
     * Return ExceptionHandler Singleton
     *
     * @return ExceptionHandler
     */
    public static function getInstance()
    {
        if (null === static::$instance)
            static::$instance = new static();

        return static::$instance;
    }

    /**
     * Handle Exception
     *
     * @param Exception $exception
     *
     * @return bool
     */
    public static function handleException(Exception $exception)
    {
        if ($exception instanceof RaiseException)
            self::getInstance()->setRaiseMessage(new HTTPStatus($exception->getCode(), $exception->getMessage()));

        JsonOutput::showJson(self::getInstance()->show(), 1);

        return false;
    }

    /**
     * Return Http Message
     *
     * @return HTTPStatus
     */
    public function show()
    {
        if (self::getInstance()->getRaiseMessage() !== null)
            return self::getInstance()->getRaiseMessage()->returnStatus();

        return (new HTTPStatus())->returnStatus();
    }

    /**
     * Get Raise Message
     *
     * @return HTTPStatus
     */
    public function getRaiseMessage()
    {
        return self::getInstance()->raiseMessage;
    }

    /**
     * Set Raise Message
     *
     * @param HTTPStatus $raiseMessage
     */
    public function setRaiseMessage(HTTPStatus $raiseMessage)
    {
        self::getInstance()->raiseMessage = $raiseMessage;
    }
}
