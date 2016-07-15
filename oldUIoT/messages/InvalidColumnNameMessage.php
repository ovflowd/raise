<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class InvalidColumnNameMessage
 * @package UIoT\messages
 */
final class InvalidColumnNameMessage extends RaiseMessage
{
    /**
     * InvalidColumnNameMessage constructor.
     *
     * @param string $columnName
     */
    public function __construct($columnName = '')
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 6);
        $message->addContent('message', "Invalid Requested Column: {$columnName}");

        parent::__construct($message);
    }
}