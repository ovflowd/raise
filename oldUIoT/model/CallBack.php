<?php

namespace UIoT\model;

use UIoT\interfaces\CallBack as CallBackInterface;

/**
 * Class CallBack
 * @package UIoT\model
 */
class CallBack implements CallBackInterface
{
    /**
     * Get a CallBack result
     *
     * @param UIoTRequest $request
     * @return mixed
     */
    public static function getCallBack(UIoTRequest $request)
    {
        return '';
    }
}
