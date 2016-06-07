<?php

namespace UIoT\control;

use UIoT\model\UIoTRequest;
use UIoT\util\RequestInput;

/**
 * Class RequestControl
 * @package UIoT\control
 */
final class RequestController
{
    /**
     * Executes a request.
     *
     * @param RequestInput $request
     * @return UIoTRequest
     */
    public function createRequest(RequestInput $request)
    {
        return $request->getRequestData();
    }
}
