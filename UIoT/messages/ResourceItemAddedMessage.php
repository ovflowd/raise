<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class ResourceItemAddedMessage
 * @package UIoT/messages
 */
final class ResourceItemAddedMessage extends RaiseMessage
{
    /**
     * ResourceItemAddedMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('message', 'Resource Item Added');

        parent::__construct(200, $message);
    }
}