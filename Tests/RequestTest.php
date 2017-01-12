<?php

include('httpful.phar');

class RequestTester
{
	private $raise_ip = '172.16.4.151/RAISe';

	public function testListAllClients()
	{
		$url = "http://{$this->raise_ip}/client/list";
		$response = \Httpful\Request::get($url)->send();
		echo "All clients response: ". '<br>';
		echo $response;
	}

	public function testInsertClient()
	{
		$url = "http://{$this->raise_ip}/client/register";

		$body = json_encode(array("name" => "renato", 
				  "chipset" => "arm", 
			      "mac" => "0a:00:27:00:00:00",
			      "serial" => "7ARET90OIPUU",
			      "processor" => "amd-64",
			      "channel" => "olfato"));	

		$response = \Httpful\Request::post($url)->sendsJson()->body($body)->send();
		echo "Complete client insertion: " . "<br>";
		echo $response;
	}

	public function testInsertClientWithoutChannel()
	{
		$url = "http://{$this->raise_ip}/client/register";

		
		$body = json_encode(array("name" => "renato", "chipset" => "arm", 
			      "mac" => "0a:00:27:00:00:00",
			      "serial" => "7ARET90OIPUU",
			      "processor" => "amd-64"));

		$response = \Httpful\Request::post($url)->sendsJson()->body($body)->send();
		echo "Client without channel: ";
		echo json_decode($response)->codeHttp == 400 ? "TEST PASSED...." . "<br>" : "TEST FAILED...." . "<br>";
		echo $response;
	}
}
