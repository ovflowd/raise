<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class InvalidSqlOperatorMessage
 * @package UIoT\messages
 */
final class InvalidSqlOperatorMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Invalid Operator on Database', 200);
    }
}