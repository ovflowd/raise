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
        if ($request->getResource()->getFriendlyName() == 'devices') {
            $this->callBackResult = (new TokenInsertionCallBack($request))->getCallBack();
        } elseif (!$request->query->has('token')) {
            $this->callBackResult = MessageHandler::getInstance()->getResult(new InvalidTokenMessage);
        } elseif (RequestInput::getTokenManager()->validateCode($request->query->get('token'))) {
            RequestInput::getTokenManager()->updateTokenExpire($request->query->get('token'));

            if ($request->getResource()->getFriendlyName() == 'services') {
                $this->callBackResult = (new ServiceInsertionCallBack($request))->getCallBack();
            } else {
                $this->callBackResult = RequestInput::getRequest()->executeRequest();
            }
        } else {
            $this->callBackResult = MessageHandler::getInstance()->getResult(new InvalidTokenMessage);
        }
    }
}