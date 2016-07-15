<?php

namespace UIoT\interfaces;

use UIoT\model\UIoTRequest;

/**
 * Interface CallBack
 * @package UIoT\interfaces
 */
interface CallBack
{
    /**
     * Get a CallBack result
     *
     * @param UIoTRequest $request
     * @return mixed
     */
    public static function getCallBack(UIoTRequest $request);
}