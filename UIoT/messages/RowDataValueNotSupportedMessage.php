<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class RowDataValueNotSupportedMessage
 * @package UIoT\messages
 */
final class RowDataValueNotSupportedMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Invalid Request Data', 2);
    }
}