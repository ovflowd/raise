<?php

namespace UIoT\util;

use UIoT\model\RaiseMessage;
use UIoT\model\UIoTSingleton;

/**
 * Class MessageHandler
 * @package UIoT\util
 */
class MessageHandler extends UIoTSingleton
{
    /**
     * @var RaiseMessage
     */
    protected $message = null;

    /**
     * Return ExceptionHandler Singleton
     *
     * @return MessageHandler|UIoTSingleton
     */
    public static function getInstance()
    {
        return parent::getInstance();
    }

    /**
     * Show Message and End Execution
     *
     * @param RaiseMessage $message
     */
    public function endExecution(RaiseMessage $message)
    {
        die($this->showMessage($message));
    }

    /**
     * Show Message
     *
     * @param RaiseMessage $message
     */
    public function showMessage(RaiseMessage $message)
    {
        echo JsonOutput::encode($this->getResult($message));
    }

    /**
     * Get Message Result
     *
     * @param RaiseMessage $message
     * @return string
     */
    public function getResult(RaiseMessage $message)
    {
        $this->message = $message;

        return $this->message->getResult();
    }

    /**
     * Get Message Class
     *
     * @param RaiseMessage $message
     * @return RaiseMessage
     */
    public function getMessage(RaiseMessage $message)
    {
        $this->message = $message;

        return $this->message;
    }
}
