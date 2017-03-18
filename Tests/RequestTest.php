<?php

include('httpful.phar');

class RequestTester
{

	private $raise_ip = 'localhost';


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
			      "channel" => "olfato",
						"timestamp" => round(microtime(true) *1000)
						));

		$response = \Httpful\Request::post($url)->sendsJson()->body($body)->send();
		echo "Complete client insertion: " . "<br>";
		echo $response;
		return $response;
	}

	public function registerServices($token)
	{
		$url = "http://{$this->raise_ip}/service/register";

		$body = json_encode(array(
					"services" => array(array('name'=>'temperature','parameters'=>array('temp'=>'vagabond') , 'return_type' => 'float'),array('name'=>'pressure','parameters'=>array('press'=>'double') , 'return_type' => 'float')),
						"timestamp" => round(microtime(true) *1000),
						'tokenId' => $token
						));

		$response = \Httpful\Request::post($url)->sendsJson()->body($body)->send();
		echo "Complete service insertion: " . "<br>";
		echo $response;
		return $response;
	}
	
	public function postData($data)
	{
		$url = "http://{$this->raise_ip}/data/register";

		$body = json_encode($data);

		$response = \Httpful\Request::post($url)->sendsJson()->body($body)->send();
		echo "Complete data insertion: " . "<br>";
		echo $response;
		return $response;
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
		echo json_decode($response)->code == 400 ? "TEST PASSED...." . "<br>" : "TEST FAILED...." . "<br>";
		echo $response;
	}


	public function testAutoRegister()
	{
			$response = $this->testInsertClient();
			$token = json_decode($response->body)->tokenId;
			echo "<br><br>";
			//$token = "BatatossauroTraps";
			sleep(1); //necessário devido ao delay do couchbase )=
			$serv_response = $this->registerServices($token);
			sleep(1);
			$service = json_decode($serv_response)->services;
			$dados = [ 'token' => $token,  array(array('service_id' => $service[1]->service_id , 'values' => array(array('press'=>(int) 4))))];
			echo "<br><br>";
			$postData = $this->postData($dados);

	}

}