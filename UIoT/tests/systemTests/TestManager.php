<?php

class TestManager
{

    const RAISE = "http://raise.uiot.org/";
    private $requests;

    /**
     * TestManager constructor.
     */
    public function __construct()
    {
        $testResults = "";
        $this->requests = $this->populateRequests();
        foreach($this->requests as $request){
            $testResults += $this->testGetRequest($request);
        }
        echo $testResults;
    }

    /**
     * @return array
     */
    private function populateRequests()
    {
        $requestArray = array(
            new RequestTestCase(RAISE.""),//Todo. construct requests based on https://github.com/UIoT/uiot_academics/blob/master/docs/documentation/DeviceRequests.pdf
            new RequestTestCase(RAISE."")
            // etc
        );
        return $requestArray;
    }

    /**
     * @param RequestTestCase $requestTestCase
     * @return bool
     */
    private function testGetRequest(RequestTestCase $requestTestCase)
    {
        $response = $this->doGetRequest( $requestTestCase->getRequest() );
        if( strcmp( $response, $requestTestCase->getExpected() ) === 0 )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * interfaces raise tests and Httpful lib for method GET
     * @param $httpGetUri
     * @return mixed
     */
    private function doGetRequest($requestTestCase){
        return \Httpful\Request::get( $requestTestCase->getUri() )->send();
    }

    /**
     * interfaces raise tests and Httpful lib for method POST
     * @param $httpPostUri
     * @param $httpPostBody
     * @return mixed
     */
    private function doPostRequest($requestTestCase){
        return \Httpful\Request::post( $requestTestCase->getUri() )
            ->body( $requestTestCase->getBody() )//todo check
            ->sendsJson() //todo check, originally '->sendsXml()'
            ->send();
    }

}
