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
use Raise\Treaters\MessageOutPut;
class DatabaseParser
{
    private $userName = NULL;
    private $password = NULL;
    private $serverAddress = "127.0.0.1:8091";
    private function connect($bucket, $serverAddress)
    {
        $cluster = new CouchbaseCluster($serverAddress);
        $bucket = $cluster->openBucket($bucket);
        return $bucket;
    }
    //Method for performing a insert query on the database.
    //return string
    public function insert($resquestObj)
    {
        try
        {
            $bucket = $this->connect($resquestObj->bucket, $this->serverAddress);
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $result = $bucket->upsert($token, $resquestObj->parameters);
            $response = json_encode(array(
                'code' => 200,
                'message' => (new MessageOutPut())->messageHttp(200)->message,
                'token' => $result->cas
            ));
            return $response;
        }
        catch(CouchbaseException $e)
        {
            return (new MessageOutPut())->messageHttp($e->getCode());
        }
    }
    //Method for performing a update query on the database.
    //return string
    private function update($resquestObj)
    {
        try
        {
            $bucket = connect($UserName, $Password, $resquestObj->bucket, $resquestObj->serverAddress);
            $doc = $resquestObj->name;
            foreach ($resquestObj->params as $param => $paramValue)
            {
                array_push($doc->$key, $paramValue);
            }
            $bucket->replace("u:" . $resquestObj->name, $doc);
            $response = json_encode(array(
                'code' => 200,
                'message' => $resquestObj->message
            ));
            return $response;
        }
        catch(CouchbaseException $e)
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
            $bucket = $this->connect($requestObj->bucket, $this->serverAddress);
            $queryStr = "SELECT * FROM `teste` WHERE";
            foreach ($requestObj->parameters as $key => $parameter)
            {
                $queryStr = $queryStr . " " . $key . "=\$$key" . "AND ";
            }
            $queryStr = substr($queryStr, 0, -4);
            $query = \CouchbaseN1qlQuery::fromString($queryStr);
            $query->namedParams($requestObj->parameters);
            $result = $bucket->query($query);
            $responseRows = array();
            foreach ($result->rows as $row)
            {
                $bucket = $requestObj->bucket;
                $responseRows[] = $row->$bucket;
            }
            $response = json_encode(array(
                'code' => 200,
                'values' => json_encode($responseRows)
            ));
            return $response;
        }
        catch(CouchbaseException $e)
        {
            return (new MessageOutPut())->messageHttp($e->getCode());
        }
    }
}
