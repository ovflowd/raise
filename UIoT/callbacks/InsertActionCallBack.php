<?php

namespace UIoT\callbacks;

use UIoT\messages\ActionReceiveMessage;
use UIoT\model\CallBack;
use UIoT\model\UIoTRequest;
use UIoT\util\MessageHandler;
use UIoT\util\RequestInput;

/**
 * Class InsertActionCallBack
 * @package UIoT\callbacks
 */
class InsertActionCallBack extends CallBack
{
    /**
     * InsertActionCallBack constructor.
     *
     * @param UIoTRequest $request
     */
    public function __construct($request)
    {
        $response = RequestInput::getResourceController()->executeRequest($request);
        $serviceId = RequestInput::getDatabaseManager()->getLastId();

        if ($serviceId > 0) {
            $tokenId = RequestInput::getTokenManager()->getDeviceIdFromToken($request->query->get("token"));

            $serviceName = $request->query->get("name");
            $serviceType = $request->query->get("type");

            RequestInput::getDatabaseManager()->fastExecute("INSERT INTO actions VALUES (NULL, :act_name, :act_type, '', '0')",
                [':act_name' => $serviceName, ':act_type' => $serviceType]);

            $actionId = RequestInput::getDatabaseManager()->getLastId();

            RequestInput::getDatabaseManager()->fastExecute("INSERT INTO service_actions VALUES (:srvc_id, :act_id, '0')",
                [':srvc_id' => $tokenId, ':act_id' => $actionId]);

            $this->callBackResult = MessageHandler::getInstance()->getResult(new ActionReceiveMessage($serviceId, $tokenId));
        } else {
            $this->callBackResult = $response;
        }
    }
}