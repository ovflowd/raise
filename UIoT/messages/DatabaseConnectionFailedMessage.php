<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class DatabaseConnectionFailedMessage
 * @package UIoT\messages
 */
final class DatabaseConnectionFailedMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('RAISE can\'t Connect on UIoT Data Server', 8);
    }
}