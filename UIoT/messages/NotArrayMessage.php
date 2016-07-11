<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class NotArrayMessage
 * @package UIoT\messages
 */
final class NotArrayMessage extends RaiseMessage
{
    /**
     * NotArrayMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('message', 'Failed to Parse Incoming Data');

        parent::__construct(4, $message);
    }
}