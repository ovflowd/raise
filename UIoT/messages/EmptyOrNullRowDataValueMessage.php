<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class EmptyOrNullRowDataValueMessage
 * @package UIoT/messages
 */
final class EmptyOrNullRowDataValueMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Data Server Returned Exception on Gathering Data', 7);
    }
}