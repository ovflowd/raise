<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class InvalidRaiseResourceMessage
 * @package UIoT/messages
 */
final class InvalidRaiseResourceMessage extends RaiseMessage
{
    /**
     * InvalidRaiseResourceMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('message', 'Invalid Resource Requested to Raise');

        parent::__construct(400, $message);
    }
}