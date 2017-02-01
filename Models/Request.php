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
        *@var
        */
        private $method;
        /**
        *@var
        */
        private $protocol;
        /**
        *@var
        */
        private $server_ip;
        /**
        *@var
        */
        private $remote_ip;
        /**
        *@var
        */
        private $path;
        /**
        *@var
        */
        private $params;
        /**
        *@var
        */
        private $isValid;
        /**
        *@var
        */
        private $body;
        /**
        *@var
        */
        private $response;

    /**
    *Construct Object request
    */

    public function __construct($method, $protocol, $serverAddress, $clientAddress, $path, $queryString, $body){
        $this->method = $method;
        $this->protocol = $protocol;
        $this->server_ip = $serverAddress;
        $this->remote_ip = $clientAddress;
        $this->setPath($path);
        $this->setParams($queryString);
        $this->body = json_decode($body, true);
        $this->reponse = 200; //default value for request reponse
        $this->isValid = true;
    }

    /**
    *Set a method on request object
    */

    public function setMethod($method){
            $this->method = $method;
    }

    /**
    *Get a method the request object
    *
    *@return  string  request method
    */

    public function getMethod(){
            return $this->method;
    }

    /**
    *Set protocol request object
    */

    public function setProtocol($protocol){
            $this->protocol = $protocol;
    }

    /**
    *Get protocol request object
    *
    *@return string protocol request object
    */

    public function getProtocol(){
            return $this->protocol;
    }

    /**
    *Set address IP SERVER_PROTOCOL
    */

    public function setServer_IP($server_ip){
            $this->server_ip = $server_ip;
    }

    /**
    *Get address IP Server request object
    *
    *@return string IP server request object
    */

    public function getServer_IP(){
            return $this->server_ip;
    }

    /**
    *Set Remote IP request object
    */

    public function setRemote_IP($Remote_ip){
            $this->remote_ip = $remote_ip;
    }

    /**
    *Get Remote IP request object
    *
    *@return string remote IP request object
    */

    public function getRemote_IP(){
            return $this->remote_ip;
    }

    /**
    *Set path on request object
    */

    public function setPath($path){
        $s = explode("?", $path); //divide path from query string
        $this->path = explode("/", $s[0]); // separate path into array
    }

    /**
    *Get
    *
    *@return
    */

    public function getPath(){
        return $this->path;
    }

    /**
    *Set
    */

    public function setParams($paramsString)
    {
        parse_str($paramsString, $paramsArray);
            $this->params = $paramsArray;
    }


    /**
    *Set
    */

    public function setParameters($params){
             $this->params = $params;
             return $this->params;
    }

    /**
    *Get
    *
    *@return
    */

    public function getParameters(){
            return $this->params;
    }

    /**
    *Get
    *
    *@return
    */

    public function getBody() {
        return $this->body;
    }

    public function isValid() {
            return $this->isValid;
    }

    /**
    *Set
    */

    public function setValid($validate) {

        $this->isValid = $validate;
    }

    /**
    *Set
    */

    public function setResponseCode($code)
    {
    $this->response = $code;
    }

    /**
    *Get
    *
    *@return string 
    */

    public function getReponseCode() {
        return $this->response;
    }

}
