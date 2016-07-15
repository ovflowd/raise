<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class UnexistentArgumentMessage
 * @package UIoT/messages
 */
final class UnexistentArgumentMessage extends RaiseMessage
{
    /**
     * UnexistentArgumentMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 404);
        $message->addContent('message', 'The desired argument combination resulted in mismatch.');

        parent::__construct($message);
    }
}