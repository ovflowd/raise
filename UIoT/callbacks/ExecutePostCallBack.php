<?php

namespace UIoT\callbacks;

use UIoT\messages\InvalidTokenMessage;
use UIoT\model\CallBack;
use UIoT\model\UIoTRequest;
use UIoT\util\MessageHandler;
use UIoT\util\RequestInput;

/**
 * Class ExecutePostCallBack
 * @package UIoT\callbacks
 */
class ExecutePostCallBack extends CallBack
{
    /**
     * ExecutePostCallBack constructor.
     *
     * @param UIoTRequest $request
     */
    public function __construct($request)
    {
        if ($request->getResource() == "devices") {
            $this->callBackResult = (new TokenInsertionCallBack($request))->getCallBack();
        } elseif (!$request->query->has("token")) {
            $this->callBackResult = MessageHandler::getInstance()->getResult(new InvalidTokenMessage);
        } elseif (RequestInput::getTokenManager()->validateCode($request->query->get("token"))) {
            RequestInput::getTokenManager()->updateTokenExpire($request->query->get("token"));

            if ($request->getResource() == "services") {
                $this->callBackResult = (new ActionInsertionCallBack($request))->getCallBack();
            } else {
                $this->callBackResult = RequestInput::getResourceController()->executeRequest($request);
            }
        } else {
            $this->callBackResult = MessageHandler::getInstance()->getResult(new InvalidTokenMessage);
        }
    }
}