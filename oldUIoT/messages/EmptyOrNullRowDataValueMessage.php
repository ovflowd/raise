<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class EmptyOrNullRowDataValueMessage
 * @package UIoT/messages
 */
final class EmptyOrNullRowDataValueMessage extends RaiseMessage
{
    /**
     * EmptyOrNullRowDataValueMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 404);
        $message->addContent('message',
            'The requested Resource doesn\'t have items stored in database with the matching criteria.');

        parent::__construct($message);
    }
}