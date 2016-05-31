<?php

namespace UIoT\validators;

use UIoT\exceptions\InvalidRaiseResourceException;
use UIoT\model\UIoTRequest;
use UIoT\database\DatabaseExecuter;

class RequestValidator
{



    private $resources;

    public function __construct($resources)
    {
        $this->resources = $resources;
    }

    /**
     * @param UIoTRequest $request
     * @return boolean
     */

    public function validate(UIoTRequest $request){
        $isValid =
            //$this->validateFormat($request) &&
            //$this->validateProtocol($request) &&
            //$this->validateMethod($request) &&
            //$this->validateParameters($request) &&
            //$this->validateValues($request);
            $this->validateResource($request);

       return $isValid;
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
       if(!in_array($request->getResource(),$this->getResourcesNames()))
           throw new InvalidRaiseResourceException();

        return true;
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

    /**
     *
     */
    private function setResources($resources)
    {
        $this->resources = $resources;
    }

    public function getResources()
    {
        return $this->resources;
    }

    private function getResourcesNames()
    {
        $names = array();
        foreach($this->resources as $resource)
        {
            $names[] = $resource->getFriendlyName();
        }

        return $names;
    }
}