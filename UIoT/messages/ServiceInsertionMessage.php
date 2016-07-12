<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class ServiceInsertionMessage
 * @package UIoT\messages
 */
final class ServiceInsertionMessage extends RaiseMessage
{
    /**
     * ServiceInsertionMessage constructor.
     *
     * @param string $actionId
     * @param string $serviceId
     * @param string $deviceId
     */
    public function __construct($actionId = '', $serviceId = '', $deviceId = '')
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 200);
        $message->addContent('device_id', $deviceId);
        $message->addContent('service_id', $serviceId);
        $message->addContent('action_id', $actionId);

        parent::__construct($message);
    }
}
