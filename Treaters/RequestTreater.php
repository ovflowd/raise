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

namespace Raise\Treaters;

include_once 'Models/Request.php';
include_once 'Treaters/MessageOutPut.php';
include_once 'Controllers/SecurityController.php';
include_once 'Database/QueryGenerator.php';
include_once 'Database/DatabaseParser.php';
use Raise\Models\Request;
use Raise\Controllers\SecurityController;
use DatabaseParser;

/**
 *Class RequestTreater.
 */
class RequestTreater
{
    /**
     *@var array
     */
    private $requestInfo = array(
        'protocol' => 'SERVER_PROTOCOL',
        'method' => 'REQUEST_METHOD',
        'path' => 'PATH_INFO',
        'query' => 'QUERY_STRING',
        'sender' => 'REMOTE_ADDRESS',
    );
    /**
     *@var array error code for validate info
     */
    private $codes = array(
        'protocol' => 505,
        'method' => 405,
        'path' => 400,
        'query' => 400,
        'remote' => 403,
    );

    private $protocols = array(
      'HTTP/1.0', 'HTTP/1.1', 'HTTPS/1.0', 'HTTPs/1.1',
    );

    private $AllowedBuckets = array(
      'client', 'data', 'service',
    );

    /**
     *Create a request and validate parameters.
     *
     *@return $response Message exception response
     *@return $a        Valid request
     */
    public function execute()
    {
        $request = $this->create();
        $this->validate($request);
        if (!$request->isValid()) {
            return (new MessageOutPut())->messageHttp($request->getReponseCode());
        }
        $security = new SecurityController();
        if ($security->validate($request) === true) {
            $generator = new \QueryGenerator();
            $response = $generator->generate($request);

            return $response;
        } else {
            return $security->validate($request);
        }
    }

    /**
     *Create Request Object.
     *
     *@return $request Object request
     */
    public function create()
    {
        $request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['SERVER_PROTOCOL'], $_SERVER['SERVER_ADDR'], $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING'], file_get_contents('php://input'));

        return $request;
    }

    /**
     *Request object validation.
     *
     *@param object  $request  Request object
     *
     *@return bool          Validation value
     */
    private function validate($request)
    {
        if ($this->emptyValidation($request) && $this->validationBucket($request) && $this->validationMethod($request) && $this->validateMethodMoreBucket($request)) {
            $request->setResponseCode(200);
            $request->setValid(true);

            return;
        }

        return;
    }

    private function emptyValidation($request)
    {
        if ($request->getPath()['bucket'] === null || empty($request->getPath()['bucket']) && empty($request->getPath()['address']) && $request->getPath()['method'] == null || empty($request->getPath()['method'])) {
            $request->setResponseCode(202);
            $request->setValid(false);

            return false;
        }

        return true;
    }

    private function validationBucket($request)
    {
        if (!in_array($request->getPath()['bucket'], $this->AllowedBuckets)) {
            $request->setResponseCode(403);
            $request->setValid(false);

            return false;
        }

        return true;
    }

    private function validationMethod($request)
    {
        if ($request->getPath()['bucket'] !== 'data') {
            $database = (new DatabaseParser($request))->getBucket();
            $query = \CouchbaseN1qlQuery::fromString('SELECT input FROM metadata WHERE `method` = $method AND `bucket` = $bucket');
            $query->namedParams(array('bucket' => $request->getPath()['bucket'], 'method' => $request->getMethod()));
            $parameters = $database->query($query)->rows[0]->input;
            switch ($request->getMethod()) {
            case 'get':
                return $this->validationMethodGet($request, $parameters);
            break;
            case 'post':
                if ($request->getPath()['method'] == 'revalidate') {
                    return $this->validateRevalidate($request, $parameters);
                }

                return $this->validationMethodPost($request, $parameters);
            break;
        }
        } else {
            if ($request->getMethod() === 'post') {
                return $this->validateDataInsertion($request);
            }
        }
    }

    //TODO: make this a real function
    private function validateRevalidate($request, $parameters)
    {
        return true;
    }

    private function validationMethodGet($request, $parameters)
    {
        if (count(array_diff(array_keys($request->getParameters()), array_keys((array) $parameters))) > 1) {
            $request->setResponseCode(400);
            $request->setValid(false);

            return false;
        } elseif (count(array_diff(array_keys($request->getParameters()), array_keys((array) $parameters))) === 1
                  && !in_array('tokenId', array_diff(array_keys($request->getParameters()), array_keys((array) $parameters)))) {
            $request->setResponseCode(400);
            $request->setValid(false);

            return false;
        }

        return true;
    }

    private function validateDataInsertion($request)
    {
        $token = $request->getBody()['token'];
        $services = $request->getBody()[0];
        $database = (new DatabaseParser($request))->getBucket();
        $query = \CouchbaseN1qlQuery::fromString('SELECT * FROM token WHERE `tokenId` = $token');
        $query->namedParams(array('token' => $token));
        $parameters = $database->query($query)->rows;

        if ($parameters[0]->token->time_fim <= round(microtime(true) * 1000)) {
            $request->setResponseCode(401);
            $request->setValid(false);

            return false;
        }

        foreach ($services as $service) {
            $database = (new DatabaseParser($request))->getBucket();
            $query = \CouchbaseN1qlQuery::fromString('SELECT services FROM client WHERE `tokenId` = $token');
            $query->namedParams(array('token' => $token));
            $parameters = $database->query($query)->rows;

            $compare = json_decode(json_encode($compare), true);
            $compare = $compare['services'][$service['service_id']]['parameters'];

            foreach ($service['data_values'] as $key => $val) {
                if (gettype($val) !== $compare[$key]) {
                    $request->setResponseCode(400);
                    $request->setValid(false);

                    return false;
                }
            }
        }

        return true;
    }

    private function validationMethodPost($request, $parameters)
    {
        echo 'hey';
        if (!empty(array_diff(array_keys((array) $parameters), array_keys($request->getBody())))) {
            var_dump(array_diff(array_keys((array) $parameters), array_keys($request->getBody()))); 
            exit();
            $request->setResponseCode(400);
            $request->setValid(false);
            return false;
        } 
        return true;
    }

    private function validateMethodMoreBucket($request)
    {
        $database = (new DatabaseParser($request))->getBucket();
        $query = \CouchbaseN1qlQuery::fromString('SELECT COUNT(`bucket`) FROM metadata WHERE `method` = $method AND `bucket` = $bucket');
        $query->namedParams(array('bucket' => $request->getPath()['bucket'], 'method' => $request->getMethod()));
        if ($database->query($query)->rows[0]->{'$1'} <= 0) {
            $request->setResponseCode(422);
            $request->setValid(false);

            return false;
        }

        return true;
    }

    /**
     *Comparate protocol name in private array $protocols.
     *
     *@param string  $protocol Request protocol for validation
     *
     *@return bool          request validation protocol value
     */
    private function protocol($protocol)
    {
        return in_array($protocol, self::VALID_PROTOCOLS);
    }
    /**
     *Comparate method name in private array $methods for validation.
     *
     *@param string  $method Request method for validation
     *
     *@return bool        Request validation method valeu
     */
    private function method($method)
    {
        return in_array($method, self::VALID_METHODS);
    }
    /**
     *Comparate sender name in privare array $senders for validation.
     *
     *@param string  $sender Request sender for validation
     *
     *@return  bool       Request validation sender
     */
    private function sender($sender)
    {
        return in_array($sender, self::VALID_SENDERS);
    }
    /**
     *Validate request body.
     *
     *@param string  $body Request body for validation
     *
     *@return  object      Request object
     */
    private function body($body)
    {
        if (!$this->isValidBody($body)) {
            $request->setResponseCode(422);
            $request->setValid(false);

            return $request;
        }
        $request->setValid(true);
        $request->setResponseCode(200);

        return $request;
    }
}