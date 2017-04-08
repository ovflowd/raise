<?php
/**
 * UIoT Service Layer
 * @version alpha
 *                          88
 *                          ""              ,d
 *                                          88
 *              88       88 88  ,adPPYba, MM88MMM
 *              88       88 88 a8"     "8a  88
 *              88       88 88 8b       d8  88
 *              "8a,   ,a88 88 "8a,   ,a8"  88,
 *               `"YbbdP'Y8 88  `"YbbdP"'   "Y888
 *
 * @author Universal Internet of Things
 * @license MIT <https://opensource.org/licenses/MIT>
 * @copyright University of Brasília
 */
include_once ("Treaters/MessageOutPut.php");
include_once ('Database/DatabaseParser.php');
use Raise\Treaters\MessageOutPut;
Class QueryGenerator
{
    
    public function generate($request) 
    {
        if ($request->bucket == "service" && $request->getMethod() == "post"){
            $parsedPath = $this->parsePath($request, false);
            
            if ($parsedPath !== FALSE && $parsedPath->isValid() === TRUE) {
                $parser = new DatabaseParser($parsedPath, false); 
                $result = $parser->insert($request); 
            }
            elseif ($parsedPath->isValid() === FALSE) 
            {
                return (new MessageOutPut)->messageHttp($request->getReponseCode());
            }
            
            $parsedPath = $this->parsePath($request, true);
        } else {
            $parsedPath = $this->parsePath($request, false);
        }
        
        if ($parsedPath !== FALSE && $parsedPath->isValid() === TRUE) 
        {
            $parser = new DatabaseParser($parsedPath, false); 
            
            if ($request->getMethod() == "get")  
            { 
                
                $request = $this->buildQuery($request);
                $result = $parser->select($request);
            }
            elseif ($request->getMethod() == "post") 
            {
                $result = $parser->insert($request);
            }
            return $result;
        }
        elseif ($parsedPath->isValid() === FALSE) 
        {
            return (new MessageOutPut)->messageHttp($request->getReponseCode());
        }
    }
    
    private function generateToken() 
    {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }
    
    private function buildQuery($request) 
    {
        
        if (count($request->getParameters()) > 0 && 
        !(count($request->getParameters()) === 1 && array_key_exists("tokenId", $request->getParameters()) && $request->bucket != "data") )
        {
            $queryStr = "SELECT * FROM `" . $request->bucket . "` WHERE";
            $typeVerification = array(); 
            
            foreach ($request->getParameters() as $key => $parameter) 
            { 
                if ($request->bucket == "data" && $key !== "service_id" && $key !== "tokenId") 
                {  
                    $chave = "values.data_values." . $key;
                }
                else if ($key == "tokenId"){
                    $chave  = "token";
                } 
                else 
                {
                    $chave = $key; 
                }
                
                if (is_numeric($parameter)) 
                {
                    $typeVerification[$key] = (int)$parameter;
                    $request->setParameters($typeVerification);
                    $queryStr = $queryStr . " " . $chave . " = \$$key" . "AND ";
                }
                else
                {
                    if ($key !== "tokenId" || $request->bucket == "data"){
                        $queryStr = $queryStr . " " . $chave . " LIKE \$$key" . " AND ";    
                    }  
                }
            } 
            echo $queryStr.'<br>';
            $request->string = substr($queryStr, 0, -4);   
        }
        else
        {
            $request->string = "SELECT * FROM `" . $request->bucket . "`";
        }
        return $request;
    }
    
    private function validateToken($result, $request, $nextBucket) 
    { 
        
        if (isset($result['values'][0])) 
        {
            unset($request->string);
            $requestBody = json_decode(json_encode($result['values'][0]) , true);
            if ($requestBody["time_fim"] > round(microtime(true) * 1000)) 
            { 
                unset($requestBody["time_ini"]);
                unset($requestBody["time_fim"]);
                $request->bucket = $nextBucket;
                $request->service = true;
                $services = array();
                $i = 0; 
                
                if ($nextBucket == "service"){
                    $requestObj = $request;
                    $parserinho = new DatabaseParser($this->parsePath($requestObj, false) , true);
                    $request->string = "SELECT * FROM `service`";
                    echo '<br>'.$requestObj.'<br>';
                    $Testando = $parserinho->select($requestObj);
                    var_dump($Testando);
                    exit;   
                }
                
                foreach ($request->getBody() ['services'] as $key => $service) 
                {
                    $service['service_id'] = $i;
                    $i++;
                    $services['services'][] = $service; 
                }
                $services['tokenId'] = $request->getBody() ['tokenId'];
                $services['timestamp'] = $request->getBody() ['timestamp'];
                if ($nextBucket === "client"){
                    $request->treatedBody = json_encode(array_merge($services, $requestBody));
                } else if ($nextBucket === "service"){
                    $request->treatedBody = json_encode($services);
                }    
                $request->token = $requestBody['tokenId']; 
                unset($requestBody['tokenId']);
            }  
            else
            {
                $request->setResponseCode(401);
                $request->setValid(false);
            }
        }
        else
        {
            $request->setResponseCode(401);
            $request->setValid(false);
        }
        return $request; 
    }
    
    private function validateExpirationToken ($request, $token)
    {
        $database = (new DatabaseParser($request, false))->getBucket();
        $query = \CouchbaseN1qlQuery::fromString('SELECT * FROM token WHERE `tokenId` = $token');
        $query->namedParams(array('token' => $token));
        $parameters = $database->query($query)->rows;
        if ($parameters[0]->token->time_fim <= round(microtime(true) * 1000)) {
            return false;
        }    
        return true;
    }
    
    private function parsePath($request, $isServiceSecondTime)  
    {
        $path = $request->getPath();
        $method = $path['method'];
        
        if (!empty($method)) 
        {
            if ($request->getPath() ["method"] !== "register") 
            {
                if (!$this->validateExpirationToken($request,  $request->getParameters() ['tokenId'])) {
                    $request->setResponseCode(401);
                    $request->setValid(false); 
                } else {
                    $request->setResponseCode(200);   
                    $request->setValid(true); 
                }    
            }
            
            if ($request->getPath() ['bucket'] === "client" && $request->getPath() ['method'] == "register") 
            {
                $request->bucket = "token";
                $request->token = $this->generateToken();
                $tokenIni = round(microtime(true) * 1000);
                $tokenFim = $tokenIni + 7200000; //millisecons
                $request->treatedBody = json_encode(array_merge($request->getBody() , array(
                    'tokenId' => $request->token,
                    'time_ini' => $tokenIni,
                    'time_fim' => $tokenFim
                )));
                $parser = new DatabaseParser($request, false);
                $parser->insert($request);
                
                $request->bucket = "client";
                $request->treatedBody = json_encode($request->getBody());   
            }
            elseif ($request->getPath() ['bucket'] === "service" && $request->getPath() ["method"] == "register") 
            {
                $oldBody = $request->getBody();
                $request->bucket = "token";
                $parser = new DatabaseParser($request, false);
                //Select Client on Token bucket
                $token = $request->getBody() ['tokenId'];
                $request->string = 'SELECT * FROM `token` WHERE tokenId = $token';
                $request->setParameters(array(
                    'token' => $token 
                ));  
                $result = $parser->select($request); 
                if (!$isServiceSecondTime){
                    $request = $this->validateToken($result, $request, "client"); 
                } else {
                    $request = $this->validateToken($result, $request, "service"); 
                }
                //$request->bucket = "service";
                //End select 
                //create Client 
                //end create
            }
            elseif ($request->getPath() ['bucket'] === "data" && $request->getPath() ["method"] == "register") 
            {
                $request->token = $request->getBody() ['token'];
                $arrayTest = $request->getBody();  
                if ($this->validateExpirationToken($request, $request->token)){
                    $request->treatedBody = json_encode($request->getBody());
                    return $request;      
                } else { 
                    $request->setResponseCode(401); 
                    $request->setValid(false);  
                    return FALSE;
                } 
            }   
            else
            {
                $request->token = $this->generateToken();
                $request->treatedBody = $request->getBody();
            }
            return $request;
        }
        else
        {
            return FALSE;
        }
    }
}