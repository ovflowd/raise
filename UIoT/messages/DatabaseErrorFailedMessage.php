<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class DatabaseConnectionFailedMessage
 * @package UIoT\messages
 */
final class DatabaseErrorFailedMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Failed while operating on the Database', 8);
    }
}