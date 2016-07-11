<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class TokenInsertionMessage
 * @package UIoT\messages
 */
final class TokenInsertionMessage extends RaiseMessage
{
    /**
     * TokenInsertionMessage constructor.
     *
     * @param string $tokenHash
     */
    public function __construct($tokenHash = '')
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 200);
        $message->addContent('message', 'Resource Item Added');
        $message->addContent('token', $tokenHash);

        parent::__construct($message);
    }
}