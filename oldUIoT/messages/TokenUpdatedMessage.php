<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class TokenUpdatedMessage
 * @package UIoT\messages
 */
final class TokenUpdatedMessage extends RaiseMessage
{
    /**
     * TokenUpdatedMessage constructor.
     *
     * @param string $tokenHash
     */
    public function __construct($tokenHash = '')
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 200);
        $message->addContent('message', 'Resource Item Updated');
        $message->addContent('token', $tokenHash);

        parent::__construct($message);
    }
}