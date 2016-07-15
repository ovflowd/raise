<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class InvalidMethodMessage
 * @package UIoT\messages
 */
final class InvalidMethodMessage extends RaiseMessage
{
    /**
     * InvalidMethodMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 500);
        $message->addContent('message', 'Invalid REST Method');

        parent::__construct($message);
    }
}