<?php

namespace UIoT\callbacks;

use UIoT\managers\RequestManager;
use UIoT\messages\InvalidTokenMessage;
use UIoT\messages\TokenStillValidMessage;
use UIoT\messages\TokenUpdatedMessage;
use UIoT\model\CallBack;
use UIoT\model\UIoTRequest;
use UIoT\util\MessageHandler;

/**
 * Class TokenUpdateCallBack
 * @package UIoT\callbacks
 */
class TokenUpdateCallBack extends CallBack
{
    /**
     * Get a CallBack result
     *
     * @param UIoTRequest $request
     * @return mixed
     */
    public static function getCallBack(UIoTRequest $request)
    {
        if (!RequestManager::getTokenManager()->tokenExists($request->query->get('token'))) {
            return MessageHandler::getInstance()->getResult(new InvalidTokenMessage);
        } elseif (RequestManager::getTokenManager()->validateToken($request->query->get('token'))) {
            return MessageHandler::getInstance()->getResult(new TokenStillValidMessage);
        }

        return MessageHandler::getInstance()->getResult(new TokenUpdatedMessage(RequestManager::getTokenManager()->defineToken($request->query->get('id'))));
    }
}