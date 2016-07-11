<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class ResourceItemUpdatedMessage
 * @package UIoT/messages
 */
final class ResourceItemUpdatedMessage extends RaiseMessage
{
    /**
     * ResourceItemUpdatedMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('message', 'Resource Item Updated');

        parent::__construct(200, $message);
    }
}