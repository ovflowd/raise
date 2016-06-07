<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class CriteriaNotSupportedMessage
 * @package UIoT/messages
 */
final class CriteriaNotSupportedMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Invalid Operation at Data Manipulation', 9);
    }
}