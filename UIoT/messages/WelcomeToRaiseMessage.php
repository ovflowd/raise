<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class WelcomeToRaiseMessage
 * @package UIoT/messages
 */
final class WelcomeToRaiseMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Welcome to RAISE', 200);
    }
}