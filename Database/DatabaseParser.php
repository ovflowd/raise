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
 * important docs http://developer.couchbase.com/documentation/server/current/sdk/php/start-using-sdk.html (will be removed later)
 */
include_once 'Treaters/MessageOutPut.php';
include_once 'opt/RAISe/Config/Config.php';

use Raise\Treaters\MessageOutPut;
use Raise\Treaters\Config;

class DatabaseParser
{
    private $serverAddress;
    private $bucket;

    public function __construct($requestObj, $newBucket)
    {
        $this->serverAddress = DB_ADDRESS;
        if ($simpleQuery !== null || $simpleQuery == false) {
            $this->bucket = $this->connect($requestObj->getPath()['bucket'], $this->serverAddress);
        } else {
            $this->bucket = $this->connect($newBucket, $this->serverAddress);
        }
    }

    public function getBucket($bucket = null)
    {
        if ($bucket !== null) {
            $cluster = new CouchbaseCluster($this->serverAddress);

            return $cluster->openBucket($bucket); 
        }

        return $this->bucket;
    }

    private function response($responseRows = null)
    {
        if (isset($responseRows->cas)) {
            $response = (new MessageOutPut())->messageHttp(200);
            if ($responseRows->bucket === 'client' || $responseRows->bucket === 'service') {
                if (isset($responseRows->request->service)) {
                    $response->services = array();

                    foreach (json_decode($responseRows->request->treatedBody)->services as $key => $service) {
                        $response->services[] = array('service_id' => json_decode($responseRows->request->treatedBody, true)['services'][$key]['service_id'], 'service_name' => $service->name);
                    }
                }
                $response->tokenId = $responseRows->token;
            }
        } else {
            $response = array(
                'code' => 200,
                'values' => $responseRows,
            );
        }

        return $response;
    }

    private function treatData($untreatedResp)
    {
        for ($i = 0; $i < count($untreatedResp['values']); ++$i) {
            unset($untreatedResp['values'][$i]->token);
            $dataValues = $untreatedResp['values'][$i]->data->data_values;
            $serviceId = $untreatedResp['values'][$i]->data->service_id;
            $untreatedResp['values'][$i]->data_values = $dataValues;
            $untreatedResp['values'][$i]->service_id = $serviceId;
            unset($untreatedResp['values'][$i]->data);
        }

        return $untreatedResp;
    }

    private function parseResult($result, $request)
    {
        $responseRows = array();
        foreach ($result->rows as $row) {
            $bucket = $request->bucket;
            if ($request->isCount === true){
                $row->$bucket = new stdClass; 
                $row->$bucket->values = 1121;
            }
            $responseRows[] = $row->$bucket; 
            echo 'rowbucket:'.'<br>';
            var_dump ($row->$bucket);
        }
        var_dump($responseRows);
        exit; 
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
    public function insert($requestObj, $isRevalidate)
    {
        try {
            if ($requestObj->bucket === 'client' || $requestObj->bucket === 'token') {
                if (!$isRevalidate) {
                    $result = $this->getBucket($requestObj->bucket)->upsert($requestObj->token, $requestObj->treatedBody);
                } else {
                    $result = $this->getBucket($requestObj->bucket)->insert($requestObj->token, $requestObj->treatedBody);
                }
            } else { // Inserir novas coisas
                $result = $this->getBucket($requestObj->bucket)->insert(sha1(mt_rand(1, round(microtime(true) * 1000)).'SALT'), $requestObj->treatedBody);
            }
            $result->token = $requestObj->token;
            $result->method = $requestObj->getPath()['method'];
            $result->bucket = $requestObj->bucket;
            $result->request = $requestObj;

            return $this->response($result);
        } catch (CouchbaseException $e) {
            return (new MessageOutPut())->messageHttp($e->getCode());
        }
    }

    //Method for performing a select query on the database.
    //return string
    public function select($requestObj)
    {
        try {
            $query = \CouchbaseN1qlQuery::fromString($requestObj->string);
            $query->namedParams($requestObj->getParameters());
            $untreatedResp = $this->response($this->parseResult($this->getBucket($requestObj->bucket)->query($query), $requestObj));
            if ($requestObj->bucket === 'data') {
                return $this->treatData($untreatedResp);
            } else {
                return $untreatedResp;
            }
        } catch (CouchbaseException $e) {
            return (new MessageOutPut())->messageHttp($e->getCode());
        }
    }
}