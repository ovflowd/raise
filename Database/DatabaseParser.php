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

class DatabaseParser
{
    private $userName;
    private $password;
    private $dbName;
    private $serverAddress;

    private function connect($UserName, $Password, $bucket, $serverAddress)
    {
        $cluster = new CouchbaseCluster($serverAddress);
        $bucket = $cluster->openBucket($bucket);
        return $bucket;
    }

    //Method for performing a insert query on the database.
    //return string
    private function insert($resquestObj)
    {
        try
        {
            $bucket = connect($UserName, $Password, $resquestObj->bucket, $resquestObj->serverAddress);
            $result = $bucket->upsert('u:' . $resquestObj->name, $resquestObj->params);
            $response = json_encode(array(
                'code' => 200,
                'message' => $resquestObj->message
            ));
            return $response;
        }
        catch(Exception $e)
        {
            //Dictionary::trowMessage($e);
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
        catch(Exception $e)
        {
            //Dictionary::trowMessage($e);
        }
    }

    //Method for performing a select query on the database.
    //return string
    private function select($resquestObj)
    {
        try
        {
            $bucket = connect($UserName, $Password, $resquestObj->bucket, $resquestObj->serverAddress);
            foreach ($resquestObj->params as $key => $param)
            {
                $query = CouchbaseN1qlQuery::fromString("SELECT * FROM `default` WHERE " . key . " =" . $param);
            }
            $rows = $bucket->query($query);
            $response = json_encode(array(
                'code' => 200,
                $resquestObj->message => json_encode($rows)
            ));
            return $response;
        }
        catch(Exception $e)
        {
            //Dictionary::trowMessage($e);
        }
    }
}
