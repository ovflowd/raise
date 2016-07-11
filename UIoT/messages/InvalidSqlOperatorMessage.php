<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class InvalidSqlOperatorMessage
 * @package UIoT\messages
 */
final class InvalidSqlOperatorMessage extends RaiseMessage
{
    /**
     * InvalidSqlOperatorMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 200);
        $message->addContent('message', 'Invalid Operator on Database');

        parent::__construct($message);
    }
}