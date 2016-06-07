<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class ResourceItemAddedMessage
 * @package UIoT/messages
 */
final class ResourceItemAddedMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Resource Item Added', 200);
    }
}