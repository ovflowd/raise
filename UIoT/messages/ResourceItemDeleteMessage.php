<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class ResourceItemDeleteMessage
 * @package UIoT/messages
 */
final class ResourceItemDeleteMessage extends RaiseMessage
{
    /**
     * ResourceItemDeleteMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('message', 'Resource Item Removed');

        parent::__construct(200, $message);
    }
}