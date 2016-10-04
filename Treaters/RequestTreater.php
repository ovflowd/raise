<?php

namespace Raise\Treaters;

use Raise\model\Request;

class RequestTreater
{

		private $requestInfo = array('protocol' => 'SERVER_PROTOCOL',
									'method' =>'REQUEST_METHOD',
									'path' =>'PATH_INFO',
									'query' =>'QUERY_STRING',
									'sender' => 'REMOTE_ADDRESS');

		private $codes = array("protocol" => 505, "method" => 405, "path" => 400, "query" => 400, "remote" => 403);

		public function __construct()
		{}


		public function execute()
		{
			$request = $this->create();
		    if(!$request->isValid())
		    		return new ErrorMessage($request->getResponseCode());

		    return new SecurityManager()->validate($request);
		}

		public function create() {
			$request = new Request();

			foreach($requestInfo as $key => $info) {
				$this->validate($_SERVER[$info], $key, $request));
			}

			return $request;
		}

		private function validate($information, $category, &$request)
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
			return in_array($sener, self::VALID_SENDERS);
		}


		if(!isValidBody(file_get_contents('php://input')))
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