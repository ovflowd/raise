<?php

namespace UIoT\util;

use Exception;
use UIoT\interfaces\RaiseMessage;
use UIoT\model\UIoTSingleton;

/**
 * Class MessageHandler
 * @package UIoT\util
 */
class MessageHandler extends UIoTSingleton
{
    /**
     * @var RaiseStatus Raise Error Code Message
     */
    protected $status;

    /**
     * Return ExceptionHandler Singleton
     *
     * @return MessageHandler
     */
    public static function getInstance()
    {
        return parent::getInstance();
    }

    /**
     * Handle Message
     *
     * @param Exception $exception
     * @return string
     */
    public function getMessage(Exception $exception)
    {
        if ($exception instanceof RaiseMessage) {
            $this->getInstance()->status = new RaiseStatus($exception->getCode(), $exception->getMessage());
        }

        return $this->getInstance()->show();
    }

    /**
     * Show Message
     *
     * @param Exception $exception
     */
    public function showMessage(Exception $exception)
    {
        echo JsonOutput::showJson($this->getMessage($exception));
    }

    /**
     * Show Message and End Execution
     *
     * @param Exception $exception
     */
    public function endExecution(Exception $exception)
    {
        die($this->showMessage($exception));
    }

    /**
     * Return Http Message
     *
     * @return RaiseStatus
     */
    public function show()
    {
        if ($this->getInstance()->status !== null) {
            return self::getInstance()->status->getStatus();
        }

        return (new RaiseStatus())->getStatus();
    }
}
