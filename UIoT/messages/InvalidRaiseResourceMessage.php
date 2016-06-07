<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class InvalidRaiseResourceMessage
 * @package UIoT/messages
 */
final class InvalidRaiseResourceMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Invalid Resource Requested to Raise', 400);
    }
}