<?php

namespace UIoT\callbacks;

use UIoT\managers\RequestManager;
use UIoT\messages\TokenInsertionMessage;
use UIoT\model\CallBack;
use UIoT\model\UIoTRequest;
use UIoT\util\MessageHandler;

/**
 * Class TokenInsertionCallBack
 * @package UIoT\callbacks
 */
class TokenInsertionCallBack extends CallBack
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
        $tokenId = RequestManager::getDatabaseManager()->getLastId();

        if ($tokenId > 0) {
            return MessageHandler::getInstance()->getResult(new TokenInsertionMessage(RequestManager::getTokenManager()->defineToken($tokenId)));
        }

        return $response;
    }
}