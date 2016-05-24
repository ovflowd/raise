<?php

namespace UIoT\validators;

use UIoT\model\UIoTRequest;

class RequestValidator
{
    /**
     * @param UIoTRequest $request
     * @return boolean
     */
    public function validate(UIoTRequest $request){
        $isValid =
            $this->validateFormat($request) &&
            $this->validateProtocol($request) &&
            $this->validateMethod($request) &&
            $this->validateResource($request) &&
            $this->validateParameters($request) &&
            $this->validateValues($request);
        
        if($isValid) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @param UIoTRequest $request
     * @return boolean
     */
    private function validateFormat(UIoTRequest $request)
    {
        return false;
    }

    /**
     * @param UIoTRequest $request
     * @return boolean
     */
    private function validateResource(UIoTRequest $request)
    {
        return false;
    }

    /**
     * @param UIoTRequest $request
     * @return boolean
     */
    private function validateParameters(UIoTRequest $request)
    {
        return false;
    }

    /**
     * @param UIoTRequest $request
     * @return boolean
     */
    private function validateValues(UIoTRequest $request)
    {
        return false;
    }

    /**
     * @param UIoTRequest $request
     * @return boolean
     */
    private function validateMethod(UIoTRequest $request)
    {
        return false;
    }

    /**
     * @param UIoTRequest $request
     * @return boolean
     */
    private function validateProtocol(UIoTRequest $request)
    {
        return false;
    }
}