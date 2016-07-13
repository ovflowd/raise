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
        $message->addContent('code', 403);
        $message->addContent('message', "A required argument called '{$requiredArgument}' need to be inserted.");

        parent::__construct($message);
    }
}