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
     * @param string $dataBaseMessage
     */
    public function __construct($dataBaseMessage = '')
    {
        $message = new RaiseMessageContent();
        $message->addContent('code', 8);
        $message->addContent('message', 'Failed while operating on the Database. Result: ' . $dataBaseMessage);

        parent::__construct($message);
    }
}
