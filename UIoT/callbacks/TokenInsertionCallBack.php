<?php

namespace UIoT\callbacks;

use UIoT\messages\TokenInsertionMessage;
use UIoT\model\CallBack;
use UIoT\model\UIoTRequest;
use UIoT\util\MessageHandler;
use UIoT\util\RequestInput;

/**
 * Class TokenInsertionCallBack
 * @package UIoT\callbacks
 */
class TokenInsertionCallBack extends CallBack
{
    /**
     * TokenInsertionCallBack constructor.
     *
     * @param UIoTRequest $request
     */
    public function __construct($request)
    {
        $response = RequestInput::getRequest()->executeRequest();
        $tokenId = RequestInput::getDatabaseManager()->getLastId();

        if ($tokenId > 0) {
            $this->callBackResult = MessageHandler::getInstance()->getResult(new TokenInsertionMessage(RequestInput::getTokenManager()->defineToken($tokenId)));
        } else {
            $this->callBackResult = $response;
        }
    }
}