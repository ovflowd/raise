<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class NotArrayMessage
 * @package UIoT\messages
 */
final class NotArrayMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Failed to Parse Incoming Data', 4);
    }
}