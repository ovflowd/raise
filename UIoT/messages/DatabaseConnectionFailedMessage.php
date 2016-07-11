<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class DatabaseConnectionFailedMessage
 * @package UIoT\messages
 */
final class DatabaseConnectionFailedMessage extends RaiseMessage
{
    /**
     * DatabaseConnectionFailedMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('message', 'RAISE can\'t Connect on UIoT Data Server');

        parent::__construct(8, $message);
    }
}