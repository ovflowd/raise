<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class ResourceItemDeleteMessage
 * @package UIoT/messages
 */
final class ResourceItemDeleteMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Resource Item Removed', 200);
    }
}