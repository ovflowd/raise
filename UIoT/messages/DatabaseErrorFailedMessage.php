<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class DatabaseErrorFailedMessage
 * @package UIoT\messages
 */
final class DatabaseErrorFailedMessage extends RaiseMessage
{
    /**
     * DatabaseErrorFailedMessage constructor.
     *
     * @param int $errorCode
     * @param string $dataBaseMessage
     */
    public function __construct($errorCode = 8, $dataBaseMessage = '')
    {
        $message = new RaiseMessageContent();
        $message->addContent('code', 8);
        $message->addContent('message',
            "[{$errorCode}] Failed while operating on the Database. Result: {$dataBaseMessage}");

        parent::__construct($message);
    }
}
