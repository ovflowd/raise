<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class TokenStillValidMessage
 * @package UIoT\messages
 */
final class TokenStillValidMessage extends RaiseMessage
{
    /**
     * TokenStillValidMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 403);
        $message->addContent('message', 'The requested token hasn\'t expired.');

        parent::__construct($message);
    }
}