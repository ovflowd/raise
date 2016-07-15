<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class WelcomeToRaiseMessage
 * @package UIoT/messages
 */
final class WelcomeToRaiseMessage extends RaiseMessage
{
    /**
     * WelcomeToRaiseMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 200);
        $message->addContent('message', 'Welcome to RAISE');

        parent::__construct($message);
    }
}