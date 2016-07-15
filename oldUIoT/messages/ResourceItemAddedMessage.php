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
     *
     * @param string $resourceItemId
     */
    public function __construct($resourceItemId = '')
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 200);
        $message->addContent('message', 'Resource Item Added');
        $message->addContent('item_id', $resourceItemId);

        parent::__construct($message);
    }
}