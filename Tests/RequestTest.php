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
	
	public function testInsertClient($isValidTest)
	{
		$url = "http://{$this->raise_ip}/client/register";

		$body = (array("name" => "gladiumbisson",
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
 
	public function registerServices($token, $isValidTest)
	{
		$url = "http://{$this->raise_ip}/service/register";

		$body = (array(
					"services" => array(array('name'=>'TESTANDO_SERVICO_TUDO','parameters'=>array('isTheCakeALie'=>'bool') , 'return_type' => 'float'),array('name'=>'pressure','parameters'=>array('press'=>'integer') , 'return_type' => 'float')),
						"timestamp" => round(microtime(true) *1000),
						'tokenId' => $token
						));

        if (!$isValidTest){
            $body = json_encode($body);
        } 
		$response = \Httpful\Request::post($url)->sendsJson()->body(json_encode($body))->send();
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

		$body = json_encode(array("name" => "TESTANDO_INSERCAO_TUDO", "chipset" => "arm",
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
			
			$aServicesId = array();
			foreach (json_decode($serv_response)->services as $key => $service){
			    $aServicesId[$key] = json_decode($serv_response)->services[$key]->service_id;
			}
			
			$dados = [ 'token' => $token,  "data" => (array((array('service_id' => $aServicesId[0] , 'data_values' => array('ambiguous'=>true)))))];
			echo "<br><br>"; 
			$postData = $this->postData($dados); 
            $dados = [ 'token' => $token,  "data" => (array((array('service_id' => $aServicesId[1] , 'data_values' => array('ambiguous'=>false)))))];
			$postData = $this->postData($dados);
			return $token;
	} 

}