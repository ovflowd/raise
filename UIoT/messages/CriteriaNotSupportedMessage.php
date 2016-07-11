<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class CriteriaNotSupportedMessage
 * @package UIoT\messages
 */
final class CriteriaNotSupportedMessage extends RaiseMessage
{
    /**
     * CriteriaNotSupportedMessage constructor.
     */
    public function __construct()
    {
        $message = new RaiseMessageContent;
        $message->addContent('message', 'Invalid Operation at Data Manipulation');

        parent::__construct(9, $message);
    }
}
