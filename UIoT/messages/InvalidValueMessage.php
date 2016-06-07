<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class InvalidValueMessage
 * @package UIoT\messages
 */
final class InvalidValueMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Data has Invalid Value', 5);
    }
}