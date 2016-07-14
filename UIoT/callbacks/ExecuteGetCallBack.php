<?php

namespace UIoT\callbacks;

use UIoT\managers\RequestManager;
use UIoT\messages\EmptyOrNullRowDataValueMessage;
use UIoT\messages\InvalidTokenMessage;
use UIoT\model\CallBack;
use UIoT\model\UIoTRequest;
use UIoT\util\MessageHandler;

/**
 * Class ExecuteSelectCallBack
 * @package UIoT\callbacks
 */
class ExecuteGetCallBack extends CallBack
{
    /**
     * Get a CallBack result
     *
     * @param UIoTRequest $request
     * @return mixed
     */
    public static function getCallBack(UIoTRequest $request)
    {
        if (RequestManager::getTokenManager()->validateToken($request->query->get('token'))) {
            $returnValue = RequestManager::getRequest()->executeRequest();

            if (empty($returnValue)) {
                return MessageHandler::getInstance()->getResult(new EmptyOrNullRowDataValueMessage);
            }

            return $returnValue;
        }

        return MessageHandler::getInstance()->getResult(new InvalidTokenMessage);
    }
}