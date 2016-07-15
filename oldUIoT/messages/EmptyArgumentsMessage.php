<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class EmptyArgumentsMessage
 * @package UIoT/messages
 */
final class EmptyArgumentsMessage extends RaiseMessage
{
    /**
     * EmptyArgumentsMessage constructor.
     *
     * @param string $resourceName
     */
    public function __construct($resourceName = '')
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 403);
        $message->addContent('message', "A Resource item insertion requires arguments."
            . "Check which arguments you need requesting </properties?resource_id={$resourceName}>");

        parent::__construct($message);
    }
}