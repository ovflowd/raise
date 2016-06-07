<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class NotSqlFilterMessage
 * @package UIoT\messages
 */
final class NotSqlFilterMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Failed Due Filtering Data', 3);
    }
}