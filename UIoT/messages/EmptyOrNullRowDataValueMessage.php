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
        $message->addContent('message', 'Invalid Operator on Database');

        parent::__construct(200, $message);
    }
}