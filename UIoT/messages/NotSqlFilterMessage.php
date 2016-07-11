<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class NotSqlFilterMessage
 * @package UIoT\messages
 */
final class NotSqlFilterMessage extends RaiseMessage
{
    /**
     * NotSqlFilterMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('message', 'Failed Due Filtering Data');

        parent::__construct(3, $message);
    }
}