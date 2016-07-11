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
     * @var mixed CallBack result
     */
    protected $callBackResult;

    /**
     * Get a CallBack result
     *
     * @return mixed
     */
    public function getCallBack()
    {
        return $this->callBackResult;
    }
}
