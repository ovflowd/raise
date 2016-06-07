<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class InvalidMethodMessage
 * @package UIoT\messages
 */
final class InvalidMethodMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Invalid REST Method', 500);
    }
}