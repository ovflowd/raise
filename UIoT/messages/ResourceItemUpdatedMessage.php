<?php

namespace UIoT\messages;

use UIoT\interfaces\RaiseMessage;

/**
 * Class ResourceItemUpdatedMessage
 * @package UIoT/messages
 */
final class ResourceItemUpdatedMessage extends RaiseMessage
{
    public function __construct()
    {
        parent::__construct('Resource Item Updated', 200);
    }
}