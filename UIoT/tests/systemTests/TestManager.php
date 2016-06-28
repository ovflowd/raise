<?php

class TestManager
{

    const HTTP_VERSION = "";
    const CHARACTER_SET = "";
    const CONTENT_ENCODING = "";
    const MEDIA_TYPES = "";
    const LANGUAGE_TAGS = "";

    private $requests;

    public function __construct()
    {
        $testResults = "";
        $this->generateRequests();

        foreach($this->requests as $request){
            $testResults += $this->testGetRequest($request[request], $request[expected]);
        }
        
        echo $testResults;
    }


    private function generateRequests()
    {
        $requestArray = null;

        $requestArray[1][request] = "";
        $requestArray[1][expected] = "";

        return $requestArray;
    }


    /*
     * interfaces raise tests and Httpful lib
     * todo incomplete.
     * */
    private function testGetRequest(String $httpRequest, String $expected)
    {
        $response = \Httpful\Request::get($httpRequest)->send();

        if($expected === $response){
            return true;
        } else { return false;
        }

    }

}
