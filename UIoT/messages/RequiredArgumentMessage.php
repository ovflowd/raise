<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class RequiredArgumentMessage
 * @package UIoT/messages
 */
final class RequiredArgumentMessage extends RaiseMessage
{
    /**
     * WelcomeToRaiseMessage constructor.
     * 
     * @param string $requiredArgument
     */
    public function __construct($requiredArgument = '')
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 666);
        $message->addContent('message', 'A required argument need be inserted: ' . $requiredArgument);

        parent::__construct($message);
    }
}