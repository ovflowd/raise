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

namespace Raise\Treaters;

include_once ('Models/Request.php');
include_once ('Treaters/MessageOutPut.php');
include_once ('Controllers/SecurityController.php');
include_once ('Database/QueryGenerator.php');
include_once ('Database/DatabaseParser.php');

use Raise\Models\Request;
use Raise\Treaters\MessageOutPut;
use Raise\Controllers\SecurityController;
use \DatabaseParser;

/**
*Class RequestTreater
*
*@package Models\Request
*@package Treaters\MessageOutPut
*@package Controllers\SecurityController
*@package Database\QueryGenerator
*@package Database\DatabaseParser
*/

class RequestTreater
{
    /**
    *@var array $requestInfo
    */
    private $requestInfo = array(
        'protocol' => 'SERVER_PROTOCOL',
        'method' => 'REQUEST_METHOD',
        'path' => 'PATH_INFO',
        'query' => 'QUERY_STRING',
        'sender' => 'REMOTE_ADDRESS'
    );

    /**
    *@var array $code error code for validate info
    */
    private $codes = array(
        "protocol" => 505,
        "method" => 405,
        "path" => 400,
        "query" => 400,
        "remote" => 403
    );

    /**
    *Create a request and validate parameters
    *
    *@return $response Message exception response
    *@return $a        Valid request
    */

    public function execute()
    {
        $request = $this->create();

        $this->validate($request);

        if (!$request->isValid()) {
            return (new MessageOutPut)->messageHttp($request->getReponseCode());
        }

        $a = new SecurityController();
        if ($a->validate($request) === true)
        {
            $generator = new \QueryGenerator();
            $response = $generator->generate($request);
            return $response;
        } else
        {

            return $a->validate($request);
        }
    }

    /**
    *Create Request
    *
    *@return $request Object
    */

    public function create()
    {
        $request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['SERVER_PROTOCOL'], $_SERVER['SERVER_ADDR'], $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING'], file_get_contents('php://input'));
        return $request;
    }

    /**
    *
    */

    private function validate($request)
    {
        $request->setResponseCode(200);
        $request->setValid(true);

        $AllowedBuckets = array(

          'client',
          'data',
          'service'
        );

        $bucket = $request->getPath()[2];
        if(!in_array($bucket,$AllowedBuckets))
        {
          $request->setResponseCode(403);
          $request->setValid(false);
          return;
        }

        $request->bucket = $bucket;
        $method = strtolower($request->getMethod());
        if($method == "service")
        {
          $request->bucket = "client";
        }

        $database = (new DatabaseParser($request))->getBucket();

        $query = \CouchbaseN1qlQuery::fromString('SELECT COUNT(`bucket`) FROM metadata WHERE `method` = $method AND `bucket` = $bucket');

        $query->namedParams(array('bucket' => $bucket,'method'=>$method));

        if($database->query($query)->rows[0]->{"$1"} <= 0) {
            $request->setResponseCode(422);
            $request->setValid(false);

            return;
        }

        $query = \CouchbaseN1qlQuery::fromString('SELECT input FROM metadata WHERE `method` = $method AND `bucket` = $bucket');

        switch($request->getMethod()) {
            case 'GET':
                $query->namedParams(array('bucket' => $bucket, 'method' => $method));
                $parameters = $database->query($query)->rows[0]->input[0];

                if(!empty(array_diff(array_keys($request->getParameters()), array_keys((array)$parameters)))) {
                    $request->setResponseCode(400);
                    $request->setValid(false);

                    return;
                }

            break;
            case 'POST':
                $query->namedParams(array('bucket' => $bucket, 'method' => $method));
                $parameters = $database->query($query)->rows[0]->input[0];

                if(!empty(array_diff(array_keys((array)$parameters), array_keys($request->getBody())))) {
                    $request->setResponseCode(400);
                    $request->setValid(false);

                    return;
                }
            break;
        }
    }

    private function protocol($protocol)
    {
        return in_array($protocol, self::VALID_PROTOCOLS);
    }
    private function method($method)
    {
        return in_array($method, self::VALID_METHODS);
    }

    private function sender($sender)
    {
        return in_array($sender, self::VALID_SENDERS);
    }
    private function body($body)
    {
        if (!$this->isValidBody($body))
        {
            $request->setResponseCode(422);
            $request->setValid(false);
            return $request;
        }
        $request->setValid(true);
        $request->setResponseCode(200);
        return $request;
    }
}
