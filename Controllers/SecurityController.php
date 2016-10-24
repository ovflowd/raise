<?php
class SecurityController 
{
	
	public funtion validate(Request request)
	{
			//extract the request body as associative array
			$bodyArray = json_decode(request->getBody(), true);
			
			//checks if the client has send a large number of requests
                        if($this->isFload($bodyArray))
                        {
                        	$this->updateContext($bodyArray, 429);
				return new ErrorMessage(429); //HTTP code 429 -> too many requests       
                        }	
				
			//checks if the request token is valid	
			if(!$this->isValidToken($bodyArray["token"])) 
			{
				
				$this->updateContext($bodyArray, 401);				
				//ErrorMessage class is being develop by service team
				return new ErrorMessage(401); // HTTP code 401 -> unauthorized
			}			
			//checks if the client has pemission to do requested services
			if(!$this->hasPermission($bodyArray))
			{	
				$this->updateContext($bodyArray, 403);
				return new ErrorMessage(403); //HTTP code 403 -> forbidden
		
			}
			
			
			$this->updateContext($bodyArray, 200);
			
			//call request treater
			new RequestTreater->execute($bodyArray);	
			
	}
	private function isFload($body) 
	{
		//consult the database to verify if 
		//a client has send a frequency of requests/sec 
		//over the limit 
	}
	
	private function isValidToken($body) 
	{
		//consult the database in order to check if
		//the request token exists and has not expired  
	}
	
	private function hasPermission($body)
	{
		//consult database to verify if 
		//the client can execute the list of service 
		
	}
	private function updateContext($body, $httpCode)
	{
		//use the request body and the http code
		//to upload the client context information'
	}
	
}
