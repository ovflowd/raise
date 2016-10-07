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

class DatabaseParser
{
    protected $userName;
    protected $password;
    protected $dbName;
    protected $serverAddress;
    protected $bucket;

    public function __construct($UserName, $Password, $DbName, $serverAddress)
    {
        $cluster = new CouchbaseCluster("couchbase://127.0.0.1");
        $bucket = $cluster->openBucket("default");
    }

    //Method for performing a insert query on the database.
    //return string
    private function insert($resquestObj)
    {
        $result = $bucket->upsert('u:' . $resquestObj->name, $resquestObj->params);
        $response = json_encode(array(
            'code' => 200,
            'message' => $resquestObj->message
        ));
        echo $response;
    }

    //Method for performing a update query on the database.
    //return string
    private function update($resquestObj)
    {
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
        echo $response;
    }

    //Method for performing a select query on the database.
    //return string
    private function select($resquestObj)
    {
        foreach ($resquestObj->params as $key => $param)
        {
            $query = CouchbaseN1qlQuery::fromString("SELECT * FROM `default` WHERE " . key . " =" . $param);
        }
        $rows = $bucket->query($query);
        $response = json_encode(array(
            'code' => 200,
            $resquestObj->message => json_encode($rows)
        ));
        echo $response;
    }
}
