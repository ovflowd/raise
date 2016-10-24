<?php

namespace Raise\Treaters;

include ('Models/Request.php');
include_once ('Treaters/MessageOutPut.php');
include ('Controllers/SecurityController.php');

use Raise\Models\Request;
use Raise\Treaters\MessageController;
use Raise\Controllers\SecurityController;

class RequestTreater
{

		private $requestInfo = array('protocol' => 'SERVER_PROTOCOL',
					     'method' =>'REQUEST_METHOD',
					     'path' =>'PATH_INFO',
					     'query' =>'QUERY_STRING',
					     'sender' => 'REMOTE_ADDRESS');

		private $codes = array("protocol" => 505, "method" => 405, "path" => 400, "query" => 400, "remote" => 403);

		public function __construct()
		{

		}


		public function execute()
		{
			$request = $this->create();
		
		    if(!$request->isValid())
		    		return (new MessageController)->messageHttp($request->getReponseCode());
		    
		    $a = new SecurityController();
		    return $a->validate($request);
		}

		public function create() {
			$request = new Request($_SERVER['REQUEST_METHOD'],$_SERVER['SERVER_PROTOCOL'],$_SERVER['SERVER_ADDR'],$_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI'],$_SERVER['QUERY_STRING'],file_get_contents('php://input'));

			foreach($requestInfo as $key => $info) {
				$this->validate($_SERVER[$info], $key, $request);
			}

			//echo json_encode($request);	
			return $request;
		}

		private function validate($information, $category, $request)
		{
				if(!$this->$category($information))
				{
					$request->setResponseCode($codes[$category]);
					$request->setValid(false);
				}
		}


		private function protocol($protocol)
		{
			return in_array($protocol, self::VALID_PROTOCOLS);
		}

		private function method($method)
		{
			return in_array($method, self::VALID_METHODS);
		}

		private function path($path)
		{
			return true; //TODO
		}

		private function parameters($parameters)
		{
			return true; //TODO
		}

		private function sender($sender)
		{
			return in_array($sender, self::VALID_SENDERS);
		}

		private function body($body) {

			if(!$this->isValidBody($body))
			{
				$request->setResponseCode(422);
				$request->setValid(false);
				return $request;
			}


				$request->setValid(true);
				$request->setResponseCode(200);
				return $request;
		}
	

}
