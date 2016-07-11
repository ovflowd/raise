<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class InvalidTokenMessage
 * @package UIoT\messages
 */
final class InvalidTokenMessage extends RaiseMessage
{
    /**
     * InvalidTokenMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('message', 'Invalid or expired token');

        parent::__construct(500, $message);
    }
}