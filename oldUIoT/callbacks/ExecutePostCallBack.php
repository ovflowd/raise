<?php

namespace UIoT\callbacks;

use UIoT\managers\RequestManager;
use UIoT\messages\InvalidTokenMessage;
use UIoT\model\CallBack;
use UIoT\model\UIoTRequest;
use UIoT\util\MessageHandler;

/**
 * Class ExecutePostCallBack
 * @package UIoT\callbacks
 */
class ExecutePostCallBack extends CallBack
{
    /**
     * Get a CallBack result
     *
     * @param UIoTRequest $request
     * @return mixed
     */
    public static function getCallBack(UIoTRequest $request)
    {
        if ($request->getResource()->getFriendlyName() == 'devices') {
            return TokenInsertionCallBack::getCallBack($request);
        } elseif (RequestManager::getTokenManager()->validateToken($request->query->get('token'))) {
            if ($request->getResource()->getFriendlyName() == 'services') {
                return ServiceInsertionCallBack::getCallBack($request);
            }

            return RequestManager::getRequest()->executeRequest();
        }

        return MessageHandler::getInstance()->getResult(new InvalidTokenMessage);
    }
}