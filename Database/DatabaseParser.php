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
 * important docs http://developer.couchbase.com/documentation/server/current/sdk/php/start-using-sdk.html (will be removed later)
 */
include_once ("Treaters/MessageOutPut.php");
include_once ("Config/Config.php");

use Raise\Treaters\MessageOutPut;
use Raise\Treaters\Config;

class DatabaseParser
{
    private $serverAddress;
    private $bucket;

    public function __construct($requestObj)
    {
        $this->serverAddress = DB_ADDRESS;
        $this->bucket = $this->connect($requestObj->getPath()['bucket'], $this->serverAddress);
    }


    public function getBucket($bucket = NULL)
    {
        if($bucket !== NULL)
        {
          $cluster = new CouchbaseCluster($this->serverAddress);
          return $cluster->openBucket($bucket);
        }
        return $this->bucket;
    }

    private function response($responseRows = NULL)
    {

        if (isset($responseRows->cas))
        {

            
            $response = (new MessageOutPut())->messageHttp(200);
            if($responseRows->bucket === "client")
            {
                if($responseRows->request->service == true)
                {
                    $response->services = array();
                    var_dump(array_keys(json_decode($responseRows->request->treatedBody)->services));exit;
                    foreach($responseRows->request->treatedBody['services'] as $key=>$service)
                    {
                        $response->services[] = array('service_id' => $key, 'service_name' => $service['service_name']);
                    }
                }
              $response->tokenId = $responseRows->token;
            }

            
        } else
        {
            $response = array(
                'code' => 200,
                'values' => $responseRows
            );
        }
        
        return $response;
    }

    private function parseResult($result, $request)
    {
        $responseRows = array();
        foreach ($result->rows as $row)
        {
            $bucket = $request->bucket;
            $responseRows[] = $row->$bucket;
        }
        return $responseRows;
    }

    private function connect($bucket, $serverAddress)
    {
        $cluster = new CouchbaseCluster($serverAddress);
        $bucket = $cluster->openBucket($bucket);
        return $bucket;
    }

    //Method for performing a insert query on the database.
    //return string
    public function insert($requestObj)
    {
        try
        {
              $result = $this->getBucket($requestObj->bucket)->upsert($requestObj->token, $requestObj->treatedBody);
              $result->token = $requestObj->token;
              $result->method = $requestObj->getPath()['method'];
              $result->bucket = $requestObj->bucket;
              $result->request = $requestObj;
              return $this->response($result);

        } catch(CouchbaseException $e)
        {
            return (new MessageOutPut())->messageHttp($e->getCode());
        }
    }

    //Method for performing a select query on the database.
    //return string
    public function select($requestObj)
    {
        try
        {
            $query = \CouchbaseN1qlQuery::fromString($requestObj->string);
            $query->namedParams($requestObj->getParameters());
            return $this->response($this->parseResult($this->getBucket($requestObj->bucket)->query($query) , $requestObj));
        } catch(CouchbaseException $e)
        {
            return (new MessageOutPut())->messageHttp($e);
        }
    }
}