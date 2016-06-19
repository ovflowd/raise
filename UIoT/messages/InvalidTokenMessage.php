<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class InvalidTokenMessage
 * @package UIoT\messages
 */
final class InvalidTokenMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Invalid or expired token', 500);
    }
}