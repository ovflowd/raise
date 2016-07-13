<?php

namespace UIoT\callbacks;

use UIoT\messages\EmptyOrNullRowDataValueMessage;
use UIoT\messages\InvalidTokenMessage;
use UIoT\messages\UnexistentArgumentMessage;
use UIoT\model\CallBack;
use UIoT\model\UIoTRequest;
use UIoT\util\MessageHandler;
use UIoT\util\RequestInput;

/**
 * Class ExecuteSelectCallBack
 * @package UIoT\callbacks
 */
class ExecuteGetCallBack extends CallBack
{
    /**
     * ExecuteSelectCallBack constructor.
     *
     * @param UIoTRequest $request
     */
    public function __construct($request)
    {
        if (!$request->query->has('token')) {
            $this->callBackResult = MessageHandler::getInstance()->getResult(new InvalidTokenMessage);
        } elseif (RequestInput::getTokenManager()->validateCode($request->query->get('token'))) {
            RequestInput::getTokenManager()->updateTokenExpire($request->query->get('token'));

            $returnValue = RequestInput::getRequest()->executeRequest();

            if ($request->getResource()->getFriendlyName() == 'arguments' && empty($returnValue)) {
                $this->callBackResult = MessageHandler::getInstance()->getResult(new UnexistentArgumentMessage);
            } elseif (empty($returnValue)) {
                $this->callBackResult = MessageHandler::getInstance()->getResult(new EmptyOrNullRowDataValueMessage);
            } else {
                $this->callBackResult = $returnValue;
            }
        } else {
            $this->callBackResult = MessageHandler::getInstance()->getResult(new InvalidTokenMessage);
        }
    }
}