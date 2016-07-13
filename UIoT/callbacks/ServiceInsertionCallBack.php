<?php

namespace UIoT\callbacks;

use UIoT\messages\ServiceInsertionMessage;
use UIoT\model\CallBack;
use UIoT\model\UIoTRequest;
use UIoT\util\MessageHandler;
use UIoT\util\RequestInput;

/**
 * Class ServiceInsertionCallBack
 * @package UIoT\callbacks
 */
class ServiceInsertionCallBack extends CallBack
{
    /**
     * ServiceInsertionCallBack constructor.
     *
     * @param UIoTRequest $request
     */
    public function __construct($request)
    {
        $response = RequestInput::getResourceController()->executeRequest($request);
        $serviceId = RequestInput::getDatabaseManager()->getLastId();

        if ($serviceId > 0) {
            $tokenId = RequestInput::getTokenManager()->getDeviceIdFromToken($request->query->get('token'));

            $serviceName = $request->query->get('name');
            $serviceType = $request->query->get('type');

            RequestInput::getDatabaseManager()->fastExecute('INSERT INTO ACTIONS (ACT_NAME, ACT_TYPE) VALUES (:act_name, :act_type)',
                [':act_name' => $serviceName, ':act_type' => $serviceType]);

            $actionId = RequestInput::getDatabaseManager()->getLastId();

            RequestInput::getDatabaseManager()->fastExecute('INSERT INTO SERVICE_ACTIONS (SRVC_ID, ACT_ID) VALUES (:srvc_id, :act_id)',
                [':srvc_id' => $tokenId, ':act_id' => $actionId]);

            $this->callBackResult = MessageHandler::getInstance()->getResult(new ServiceInsertionMessage($actionId, $serviceId, $tokenId));
        } else {
            $this->callBackResult = $response;
        }
    }
}