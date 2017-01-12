<?php

include('httpful.phar');

class RequestTester
{
    private $raise_ip = '172.16.9.65/uiot_raise';

    public function testListAllClients()
    {
        $url = "http://{$this->raise_ip}/client/list";
        $response = \Httpful\Request::get($url)->send();
        echo "All clients response: ". '<br>';
        echo $response;
    }	
}  
