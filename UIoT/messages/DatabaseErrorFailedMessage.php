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
     */
    public function __construct()
    {
        $message = new RaiseMessageContent();
        $message->addContent('message', 'Failed while operating on the Database');

        parent::__construct(8, $message);
    }
}
