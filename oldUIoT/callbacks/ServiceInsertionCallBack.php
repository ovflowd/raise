<?php

namespace UIoT\callbacks;

use UIoT\managers\RequestManager;
use UIoT\messages\ServiceInsertionMessage;
use UIoT\model\CallBack;
use UIoT\model\UIoTRequest;
use UIoT\util\MessageHandler;

/**
 * Class ServiceInsertionCallBack
 * @package UIoT\callbacks
 */
class ServiceInsertionCallBack extends CallBack
{
    /**
     * Get a CallBack result
     *
     * @param UIoTRequest $request
     * @return mixed
     */
    public static function getCallBack(UIoTRequest $request)
    {
        $response = RequestManager::getRequest()->executeRequest();
        $serviceId = RequestManager::getDatabaseManager()->getLastId();

        if ($serviceId > 0) {
            $deviceId = RequestManager::getTokenManager()->getDeviceIdFromToken($request->query->get('token'));

            RequestManager::getDatabaseManager()->fastExecute('INSERT INTO ACTIONS (ACT_NAME, ACT_TYPE) VALUES (:act_name, :act_type)',
                [':act_name' => $request->query->get('name'), ':act_type' => $request->query->get('type')]);

            $actionId = RequestManager::getDatabaseManager()->getLastId();

            RequestManager::getDatabaseManager()->fastExecute('INSERT INTO SERVICE_ACTIONS (SRVC_ID, ACT_ID) VALUES (:srvc_id, :act_id)',
                [':srvc_id' => $deviceId, ':act_id' => $actionId]);

            return MessageHandler::getInstance()->getResult(new ServiceInsertionMessage($actionId, $serviceId,
                $deviceId));
        }

        return $response;
    }
}