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

namespace Raise\Models;

/**
*Class Request
*/

class Request{

        /**
        *@var string  $method    Request method
        */

        private $method;

        /**
        *@var string  $protocol  Request protocol
        */

        private $protocol;

        /**
        *@var string  $server_ip Address IP server request
        */

        private $server_ip;

        /**
        *@var string $remote_ip  Address IP clinte request
        */

        private $remote_ip;

        /**
        *@var string  $path      Path request
        */

        private $path;

        /**
        *@var string  $params    Request parameters
        */

        private $params;

        /**
        *@var boolean $isValid   Request validation
        */

        private $isValid;

        /**
        *@var string  $body      Body request
        */

        private $body;

        /**
        *@var string $response   Code request response
        */

        private $response;

    /**
    *Construct Object request
    */

    public function __construct($method, $protocol, $serverAddress, $clientAddress, $path, $queryString, $body)
    {
        $this->method = strtolower($method);
        $this->protocol = $protocol;
        $this->server_ip = $serverAddress;
        $this->remote_ip = $clientAddress;
        $this->setPath($path);
        $this->setParams($queryString);
        $this->body = json_decode($body, true);
        $this->reponse = 200; //default value for request reponse
        $this->isValid = true;

        $this->bucket = $this->getPath()['bucket'];
    }

    /**
    *Set a method on request object
    *
    *@param string $method Request method
    */

    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
    *Get a method the request object
    *
    *@return  string  request method
    */

    public function getMethod()
    {
        return $this->method;
    }

    /**
    *Set protocol request object
    *
    *@param string $protocol  Request protocol
    */

    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
    *Get protocol from request object
    *
    *@return string protocol request object
    */

    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
    *Set address IP SERVER_PROTOCOL
    *
    *@param string $server_ip Address IP server
    */

    public function setServer_IP($server_ip)
    {
        $this->server_ip = $server_ip;
    }

    /**
    *Get address IP Server from request object
    *
    *@return string IP server request object
    */

    public function getServer_IP()
    {
        return $this->server_ip;
    }

    /**
    *Set client address IP on request object
    *
    *@param string $Remote_ip Client address IP
    */

    public function setRemote_IP($Remote_ip)
    {
        $this->remote_ip = $remote_ip;
    }

    /**
    *Get Remote IP from request object
    *
    *@return string Client address IP request object
    */

    public function getRemote_IP()
    {
        return $this->remote_ip;
    }

    /**
    *Set path from query string on request object
    *
    *@param query string $path  request path query string
    */

    public function setPath($path)
    {
        $stringPath = explode("?", $path); //divide path from query string
        $arrayPath = explode("/", $stringPath[0]); // separate path into array
        $this->path = array("address" => $arrayPath[0], "bucket" => $arrayPath[1], "method" =>$arrayPath[2]); //change keys valeus
    }

    /**
    *Get path from request object
    *
    *@return string path from request object
    */

    public function getPath()
    {
        return $this->path;
    }

    /**
    *Set parameters from string on request object
    *
    *@param string $paramsString Parameters not standardized
    */

    public function setParams($paramsString)
    {
        parse_str($paramsString, $paramsArray);
        $this->params = $paramsArray;
    }

    /**
    *Set and get parameters on request object
    *
    *@param  string $params request parameters
    *@return string parameters from request object
    */

    public function setParameters($params)
    {
         $this->params = $params;
         return $this->params;
    }

    /**
    *Get parameters from request object
    *
    *@return string request object parameters
    */

    public function getParameters()
    {
        return $this->params;
    }

    /**
    *Get a body from request object
    *
    *@return string request object body
    */

    public function getBody()
    {
        return $this->body;
    }

    /**
    *Get a information of validation of request object
    *
    *@return boolean request object validation
    */

    public function isValid()
    {
        return $this->isValid;
    }

    /**
    *Set validation on request object
    *
    *@param boolean $validade Validation status value
    */

    public function setValid($validate)
    {
        $this->isValid = $validate;
    }

    /**
    *Set code of reponse message
    *
    *@param string  $code Code of response messsage
    */

    public function setResponseCode($code)
    {
        $this->response = $code;
    }

    /**
    *Get response code from request object
    *
    *@return string request object response code
    */

    public function getReponseCode()
    {
        return $this->response;
    }
}