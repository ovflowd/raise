<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class InvalidColumnNameMessage
 * @package UIoT\messages
 */
final class InvalidColumnNameMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Invalid Requested Column', 6);
    }
}