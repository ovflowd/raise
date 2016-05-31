<?php

namespace UIoT\tests\validators;

use PHPUnit_Framework_TestCase;
use UIoT\validators\RequestValidator;

class RequestValidatorTest extends PHPUnit_Framework_TestCase
{
    private $wrongFormatRequests;
    private $happyRequest; //TODO
    private $requestValidator;
    private $address; //TODO

    public function localSetUp()
    {
        $this->wrongFormatRequests = Array(
            null,
            true,
            false,
            0,
            1,
            -1,
            new \stdClass(),
            Array(),
            "");
        $this->address = "";//TODO
        $this->happyRequest = "http://".address;
        $this->requestValidator = new RequestValidator();
    }
    /**
     * @requires localSetUp();
     */
    public function testValidate()
    {
        foreach($this->wrongFormatRequests as $request )
        {
            assert($this->requestValidator->validate($request) );  
        };
    }

}
