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
     * @var RaiseStatus Raise Code Message
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
     * @param Exception $message
     * @return string
     */
    public function getMessage(Exception $message)
    {
        if ($message instanceof RaiseMessage) {
            $this->getInstance()->status = new RaiseStatus($message->getCode(), $message->getMessage());
        }

        return $this->show();
    }

    /**
     * Show Message
     *
     * @param Exception $message
     */
    public function showMessage(Exception $message)
    {
        echo JsonOutput::showJson($this->getMessage($message));
    }

    /**
     * Show Message and End Execution
     *
     * @param Exception $message
     */
    public function endExecution(Exception $message)
    {
        die($this->showMessage($message));
    }

    /**
     * Return Http Message
     *
     * @return RaiseStatus
     */
    public function show()
    {
        if ($this->status == null) {
            return (new RaiseStatus)->getStatus();
        }

        return $this->status->getStatus();
    }
}
