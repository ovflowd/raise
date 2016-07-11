<?php

namespace UIoT\messages;

use UIoT\model\RaiseMessage;
use UIoT\model\RaiseMessageContent;

/**
 * Class ActionReceiveMessage
 * @package UIoT\messages
 */
final class ActionReceiveMessage extends RaiseMessage
{
    /**
     * ActionReceiveMessage constructor.
     *
     * @param string $serviceId
     * @param string $deviceId
     */
    public function __construct($serviceId = '', $deviceId = '')
    {
        $message = new RaiseMessageContent;
        $message->addContent('code', 200);
        $message->addContent('service_id', $serviceId);
        $message->addContent('device_id', $deviceId);

        parent::__construct($message);
    }
}
