<?php

namespace Raise\Controllers;

include("Database/DatabaseParser.php");
include_once("Treaters/MessageOutPut.php");

use Raise\Treaters\MessageOutPut;

class SecurityController
{

    public function validate($request)
    {
            //extract the request body as associative array
            $bodyArray = $request->getBody();


            //checks if the client has send a large number of requests
            if($this->isFlood($bodyArray))
            {
                $this->updateContext($bodyArray, 429);
                                return (new MessageOutPut())->messageHttp(429); //HTTP code 429 -> too many requests
            }

            //checks if the request token is valid
            if(!$this->isValidToken($bodyArray["token"]))
            {

                $this->updateContext($bodyArray, 401);
                //MessageOutPut()->messageHttp class is being develop by service team
                return (new MessageOutPut())->messageHttp(401); // HTTP code 401 -> unauthorized
            }
            //checks if the client has pemission to do requested services
            if(!$this->hasPermission($bodyArray))
            {
                $this->updateContext($bodyArray, 403);
                return (new MessageOutPut())->messageHttp(403); //HTTP code 403 -> forbidden

            }


            $this->updateContext($bodyArray, 200);

            //call database parser to perform action in DB

            return true;

    }

    private function isFlood($body)
    {
        //consult the database to verify if
        //a client has send a frequency of requests/sec
        //over the limit
        return false;
    }

    private function isValidToken($body)
    {
        //consult the database in order to check if
        //the request token exists and has not expired
        return true;
    }

    private function hasPermission($body)
    {
        //consult database to verify if
        //the client can execute the list of service
        return true;

    }
    private function updateContext($body, $httpCode)
    {
        //use the request body and the http code
        //to upload the client context information'
    }

}
