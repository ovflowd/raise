<?php
/**
 * UIoT Service Layer.
 *
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
include_once 'Treaters/MessageOutPut.php';
include_once 'Database/DatabaseParser.php';
use Raise\Treaters\MessageOutPut;

class QueryGenerator
{
    public function generate($request)
    {
        if ($request->bucket == 'service' && $request->getMethod() == 'post') {
            $parsedPath = $this->parsePath($request, true);

            if ($parsedPath !== false && $parsedPath->isValid() === true) {
                //not a simple query
                $parser = new DatabaseParser($parsedPath, false);
                $result = $parser->insert($request);
            }

            if ($parsedPath->isValid() === false) {
                return (new MessageOutPut())->messageHttp($request->getReponseCode());
            }
            $parsedPath = $this->parsePath($request, false);
        } else {
            $parsedPath = $this->parsePath($request, false);
        }

        if ($parsedPath !== false && $parsedPath->isValid() === true) {
            $parser = new DatabaseParser($parsedPath, false);

            if ($request->getMethod() == 'get') {
                $request = $this->buildQuery($request);
                $result = $parser->select($request);
            } elseif ($request->getMethod() == 'post') {
                if ($request->bucket == 'data') {
                    $separedData = $this->separateData($request);

                    if (!$request->isValid()) {
                        return (new MessageOutPut())->messageHttp($request->getReponseCode());
                    }

                    foreach ($separedData as $key => $data) {
                        $request->treatedBody = json_encode($separedData[$key]);
                        $result = $parser->insert($request);
                    }
                } else {
                    $result = $parser->insert($request);
                }
            }

            return $result;
        } elseif ($parsedPath->isValid() === false) {
            return (new MessageOutPut())->messageHttp($request->getReponseCode());
        }
    }

    private function separateData($request)
    {
        $objData = json_decode($request->treatedBody, false);
        $composedData = array();

        foreach ($objData->data as $key => $service) {
            $serviceId = $objData->data[$key]->service_id;

            if (!$this->validateServiceId($request, $serviceId)) {
                $request->setResponseCode(400);
                $request->setValid(false);
            }
            $dataValues = $objData->data[$key]->data_values;
            $data = array(
                'service_id' => $serviceId,
                'data_values' => $dataValues,
            );
            $composedData[$key] = array(
                'token' => $objData->token,
                'tag' => $this->getTagList($request),
                'client_time' => json_decode($request->treatedBody, false)->client_time,
                'server_time' => json_decode($request->treatedBody, false)->server_time,
                'data' => $data,
            );
        }

        return $composedData;
    }

    private function getTagList($request)
    {
        if (isset($request->getBody()['tag'])) {
            return $request->getBody()['tag'];
        }

        return array();
    }

    private function validateServiceId($request, $namedParam)
    {
        $oldRequest = $request;
        $Testando = $this->simpleSelect($request, 'service', 'SELECT * FROM service serv UNNEST serv.services c WHERE c.service_id = '.$namedParam, $namedParam);

        if (count($Testando['values']) > 0) {
            $request->bucket = 'data';

            return true;
        }

        return false;
    }

    private function generateToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }

    private function buildQuery($request)
    {
        $request->isLimited = false;
        if (count($request->getParameters()) > 0 && !(count($request->getParameters()) === 1 && array_key_exists('tokenId', $request->getParameters()))) {
            $queryStr = 'SELECT * FROM `'.$request->bucket.'` WHERE';
            $request = $this->preValidate($request, $queryStr); 
            $queryStr = $request->queryStr; 
            if ($request->isCount === true){
                $queryStr = 'SELECT COUNT(*) as count FROM `'.$request->bucket.'` WHERE';
            } 
            $typeVerification = array();
            foreach ($request->getParameters() as $key => $parameter) {
                $chave = $this->getChave($request, $key); 
                if (is_numeric($parameter) && $chave != 'tag' && $chave != 'limit' && $chave != 'start_date' && $chave != 'end_date') {
                    $typeVerification[$key] = (int) $parameter;
                    $request->setParameters($typeVerification);
                    $queryStr = $queryStr.' '.$chave." = \$$key".' AND  ';
                } elseif ($chave != 'tag' && $chave != 'end_date' && $chave != 'start_date' && $chave != 'limit' && $chave != 'order' && $chave != 'count' && $chave != 'service_name') { 
                    if ($key !== 'tokenId') {
                        $queryStr = $queryStr.' '.$chave." LIKE \$$key".' AND  ';
                    } 
                } elseif($chave == 'service_name'){
                    $queryStr = $this->appendToQuery($queryStr, $request->getParameters()[$key]); 
                } elseif ($chave == 'start_date'){
                   $queryStr = $queryStr.' server_time >'.$request->getParameters()['start_date'].' AND  ';
                } elseif ($chave == 'end_date'){
                   $queryStr = $queryStr.' server_time <'.$request->getParameters()['end_date'].' AND  ';
                }    
            }
            $request->string = $this->finalizeQuery($request, $queryStr, false);
        } else {
            $request->string = $queryStr = 'SELECT * FROM `'.$request->bucket.'`';
        } 
        return $request;  
    }
    
    private function preValidate($request, $queryStr){
        $request->queryStr = $queryStr;
        if (isset($request->getParameters()['tag'])) {
            $request->queryStr = $this->appendTagInQuery($request).' AND ';
        }
        if (isset($request->getParameters()['limit'])) { 
            $request->isLimited = true;
            $request->limitedBy = $request->getParameters()['limit']; 
        }
        if (isset($request->getParameters()['order'])) {
            $request->isOrdered = true;
            if ($request->getParameters()['order'] === "true"){
                $request->isAsc = true;
            } else {
                $request->isAsc = false;
            }
        }
        if(isset($request->getParameters()['count'])){
            $request->isCount = true;  
        }
        return $request;
    }

    private function finalizeQuery($request, $queryStr, $noParams){
        if (!$noParams){
            $queryStr = substr($queryStr, 0, -5);
        }  
        if ($request->isOrdered == true){
            if ($request->isDesc == true){
                $queryStr .= " order by ".$request->bucket.".server_time DESC";
            } else {
                $request->isAsc = false;
            }
            
        } 
        if ($request->isLimited == true){
            $queryStr .= " LIMIT ".$request->limitedBy;
        } 
        return $queryStr;
    }
 
    private function getChave($request, $key)
    {
        if ($request->bucket == 'data' && $key !== 'service_id' && $key !== 'tokenId' && $key !== 'end_date' && $key !== 'start_date' && $key !== 'tag'  && $key !== 'limit' && $key !== 'order') {
            return 'data.data.data_values.'.$key;
        } elseif ($request->bucket == 'data' && $key == 'service_id') {
            return 'data.data.'.$key;
        } elseif ($key == 'tokenId') {
            return 'token';
        } 
        return $key; 
    }

    private function appendTagInQuery($request)
    {
        $tagsString = $request->getParameters()['tag'];
        $tagsArray = explode(',', $tagsString);

        return $this->createTagQueryString($tagsArray, $request->bucket);
    }

    private function createTagQueryString($tagsArray, $bucket)
    {
        $queryTagModel = 'select * from '.$bucket.' WHERE ';
        $queryArrayHelper = 'ANY child IN '.$bucket.'.tag SATISFIES child = ';
        foreach ($tagsArray as $key => $tag) {
            $queryTagModel .= $queryArrayHelper.'"'.$tagsArray[$key].'"'.' END AND ';
        }

        return substr($queryTagModel, 0, -5);
    }
    
    private function appendToQuery($queryStr, $serviceName)
    {
        $queryArrayHelper = ' ANY serv IN service.services SATISFIES serv.name = "'.$serviceName.'" END AND ';
        return $queryStr.$queryArrayHelper;
    }

    private function simpleSelect($request, $bucket, $queryStr, $namedParam)
    {
        $requestObj = $request;
        $requestObj->bucket = $bucket;
        $parserinho = new DatabaseParser($requestObj, $bucket);
        $requestObj->string = $queryStr;
        $Testando = $parserinho->select($requestObj);
        return $Testando;
    }

    private function validateToken($result, $request, $nextBucket)
    {
        if (isset($result['values'][0])) {
            unset($request->string);
            $requestBody = json_decode(json_encode($result['values'][0]), true);

            if ($requestBody['time_fim'] > round(microtime(true) * 1000)) {
                unset($requestBody['time_ini']);
                unset($requestBody['time_fim']);
                unset($requestBody['is_revalidated']);
                $request->bucket = $nextBucket;
                $request->service = true;
                $services = array();

                if ($nextBucket == 'service') {
                    $Testando = $this->simpleSelect($request, 'service', 'select * from service order by service.services[0].service_id desc limit 1', null);
                    $lastIndex = count($Testando['values'][0]->services);
                    $indiceFinal = $Testando['values'][0]->services[$lastIndex - 1]->service_id + 1;

                    if ($Testando['values'][0] === null) {
                        $i = 0;
                    } else {
                        $i = $indiceFinal;
                        $request->lastIndex = $indiceFinal;
                    }
                } else {
                    if ($request->lastIndex === null) {
                        $i = 0;
                    } else {
                        $i = $request->lastIndex;
                    }
                }

                foreach ($request->getBody() ['services'] as $key => $service) {
                    $service['service_id'] = $i;
                    ++$i;
                    $services['services'][] = $service;
                }
                $services['tokenId'] = $request->getBody() ['tokenId'];
                $services['tag'] = $request->getBody() ['tag'];
                $services['client_time'] = $request->getBody() ['client_time'];
                
                if ($nextBucket === 'client') { 
                    $mergedServices = array_merge($services, $requestBody); 
                    $request->treatedBody = json_encode(array_merge($mergedServices, array('server_time' =>round(microtime(true) * 1000))));
                } elseif ($nextBucket === 'service') {
                    $request->treatedBody = json_encode(array_merge($services, array('server_time' =>round(microtime(true) * 1000))));
                }   
                $request->token = $requestBody['tokenId'];
                unset($requestBody['tokenId']);
            } else {
                $request->setResponseCode(401);
                $request->setValid(false);
            }
        } else {
            $request->setResponseCode(401);
            $request->setValid(false);
        }

        return $request;
    }


    private function validateExpirationToken($request, $token)
    {
        $database = (new DatabaseParser($request, false))->getBucket();
        $query = \CouchbaseN1qlQuery::fromString('SELECT * FROM token WHERE `tokenId` = $token');
        $query->namedParams(array(
            'token' => $token,
        ));
        $parameters = $database->query($query)->rows;

        if ($parameters[0]->token->time_fim <= round(microtime(true) * 1000)) {
            return false;
        }

        return true;
    }

    public function isJson($string)
    {
        json_decode($string);

        return json_last_error() == JSON_ERROR_NONE;
    }

    public function getNextClientId($request){
        $request->bucket = "client";
        $Testando = $this->simpleSelect($request, 'client', 'select * from client order by client_id desc limit 1', null);
        $indiceFinal = $Testando['values'][0]->client_id + 1;
        if ($Testando['values'][0] === null) {
            $i = 0;
        } else {
            $i = $indiceFinal;
        }
        return $i;
    }
    
    private function parsePath($request, $isServiceSecondTime)
    {
        $path = $request->getPath();
        $method = $path['method'];

        if (!empty($method)) {
            if ($request->getPath() ['method'] === 'list') {
                if (!$this->validateExpirationToken($request, $request->getParameters() ['tokenId'])) {
                    $request->setResponseCode(401);
                    $request->setValid(false);
                } else {
                    $request->setResponseCode(200);
                    $request->setValid(true);
                }
            } else { //Mini JSON validation

                if (json_encode($request->getBody()) == 'null' || $this->isJson(json_encode($request->getBody())) === 0 || substr(json_encode($request->getBody()), 0, 1) != '{') {
                    $request->setResponseCode(400);
                    $request->setValid(false);

                    return $request;
                }
            }

            if ($request->getPath() ['bucket'] === 'client' && $request->getPath() ['method'] == 'register') {
                $request->bucket = 'token';
                $request->token = $this->generateToken();
                $tokenIni = round(microtime(true) * 1000);
                $tokenFim = $tokenIni + 7200000; //millisecons
                $nextClientId =  $this->getNextClientId($request);
                //Tem que voltar o bucket pra token pois ele eh alterado na chamada acima
                $request->bucket = 'token';
                $request->treatedBody = json_encode(array_merge($request->getBody(), array(
                    'tokenId' => $request->token,
                    'time_ini' => $tokenIni,
                    'time_fim' => $tokenFim,
                    'is_revalidated' => false,
                    'client_id' => $nextClientId,
                ))); 
                $parser = new DatabaseParser($request, false);
                $parser->insert($request);  
                $request->bucket = 'client'; 
                $arrayHelper = array_merge($request->getBody(), array('server_time' => round(microtime(true) * 1000)));
                $request->treatedBody = json_encode(array_merge($arrayHelper, array('client_id' => $nextClientId))); 
            } elseif ($request->getPath() ['bucket'] === 'service' && $request->getPath() ['method'] == 'register') {
                $oldBody = $request->getBody();
                $request->bucket = 'token';
                $parser = new DatabaseParser($request, false);
                //Select Client on Token bucket
                $token = $request->getBody() ['tokenId'];
                $request->string = 'SELECT * FROM `token` WHERE tokenId = $token';
                $request->setParameters(array( 
                    'token' => $token,
                ));
                $result = $parser->select($request);
                if (!$isServiceSecondTime) {
                    $request = $this->validateToken($result, $request, 'client');
                } else {
                    $request = $this->validateToken($result, $request, 'service');
                }
            } elseif ($request->getPath() ['bucket'] === 'client' && $request->getPath() ['method'] == 'revalidate') {
                //valida se os serviços enviados fazem parte do token
                $token = $request->getBody() ['tokenId'];
                $oldTokenObject = $this->simpleSelect($request, 'token', "select * from token where tokenId = '".$token."'", null)['values'][0];
                if ($oldTokenObject->is_revalidated) {
                    $request->setResponseCode(401); //Already revalidated
                    $request->setValid(false);

                    return $request;
                }
                $sentServices = $request->getBody() ['services'];
                $queryStr = "SELECT * FROM service WHERE tokenId = '$token'";
                $oldDocument = json_encode($this->simpleSelect($request, 'service', $queryStr, null) ['values'][0]);
                $services = json_decode($oldDocument)->services;
                $validServices = array();
                foreach ($services as $service) {
                    $validServices[] = $service->service_id;
                }
                if ($validServices == $sentServices) {
                    $newDocument = json_decode($oldDocument, false);
                    $oldToken = $newDocument->tokenId;
                    $newDocument->tokenId = $this->generateToken();
                    //Insere o novo serviço com nova tokenId no service
                    $request->bucket = 'service';
                    $request->treatedBody = json_encode($newDocument);
                    $parser = new DatabaseParser($request, false);
                    $parser->insert($request);
                    $queryStr = "SELECT * FROM client WHERE tokenId = '$oldToken'";
                    $oldTokenDocument = json_decode(json_encode($this->simpleSelect($request, 'client', $queryStr, null) ['values'][0]), false);
                    $oldClientDocument = $oldTokenDocument;
                    unset($oldTokenDocument->services);
                    unset($oldTokenDocument->tokenId);
                    //Updata a old token para revalidated como true e dá um upsert
                    $oldTokenObject->is_revalidated = true;
                    $request->bucket = 'token';
                    $request->treatedBody = json_encode($oldTokenObject);
                    $request->token = $oldTokenObject->tokenId;
                    $parser->insert($request, false);
                    //Insere uma nova token valida pro cara
                    $request->bucket = 'token';
                    $request->token = $newDocument->tokenId;
                    $tokenIni = round(microtime(true) * 1000);
                    $tokenFim = $tokenIni + 7200000; //millisecons
                    $request->treatedBody = (json_encode(array_merge(json_decode(json_encode($oldTokenDocument), true), array(
                        'tokenId' => $newDocument->tokenId,
                        'time_ini' => $tokenIni,
                        'time_fim' => $tokenFim,
                    ))));
                    $parser = new DatabaseParser($request, false);
                    $parser->insert($request);
                    //Updata o client com seu novo tokenId
                    $request->bucket = 'client';
                    $request->token = $newDocument->tokenId;
                    $oldClientDocumnet->tokenId = $newDocument->tokenId;
                    $request->treatedBody = json_encode(array_merge(json_decode(json_encode($newDocument), true), json_decode(json_encode($oldClientDocument), true)));
                } else {
                    $request->setResponseCode(401);
                    $request->setValid(false);

                    return $request;
                }
            } elseif ($request->getPath() ['bucket'] === 'data' && $request->getPath() ['method'] == 'register') {
                $request->token = $request->getBody() ['token'];
                $arrayTest = $request->getBody();

                if ($this->validateExpirationToken($request, $request->token)) {
                    $request->treatedBody = json_encode(array_merge($request->getBody(), array('server_time' => round(microtime(true) * 1000))));

                    return $request;
                } else {
                    $request->setResponseCode(401);
                    $request->setValid(false);

                    return false;
                }
            } else {
                $request->token = $this->generateToken();
                $request->treatedBody = $request->getBody();
            }

            return $request;
        } else {
            return false;
        }
    }
}