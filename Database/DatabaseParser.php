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
    private $serverAddress = "127.0.0.1:8091";
    private $bucket;

    public function __construct($resquestObj)
    {
        $this->bucket = $this->connect($resquestObj->bucket, $this->serverAddress);
    }

    public function getBucket()
    {
        return $this->bucket;
    }

    private function response($responseRows = NULL)
    {
        if ($responseRows === NULL)
        {
            $response = json_encode(array(
                'code' => 200,
                'message' => (new MessageOutPut())->messageHttp(200)->message
            ));
        } else
        {
            $response = json_encode(array(
                'code' => 200,
                'values' => json_encode($responseRows)
            ));
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
    public function insert($resquestObj)
    {
        try
        {
            $result = $this->getBucket()->upsert(bin2hex(openssl_random_pseudo_bytes(16)) , $resquestObj->parameters);
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
            $query->namedParams($requestObj->parameters);
            return $this->response($this->parseResult($this->getBucket()->query($query) , $requestObj));
        } catch(CouchbaseException $e)
        {
            return (new MessageOutPut())->messageHttp($e->getCode());
        }
    }
}
