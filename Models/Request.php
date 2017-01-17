<?php

namespace Raise\Models;

class Request{

        private $method;
        private $protocol;
        private $server_ip;
        private $remote_ip;
        private $path;
        private $params;
        private $isValid;
        private $body;
        private $response;

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

    public function setMethod($method){
            $this->method = $method;
    }

    public function getMethod(){
            return $this->method;
    }

    public function setProtocol($protocol){
            $this->protocol = $protocol;
    }

    public function getProtocol(){
            return $this->protocol;
    }

    public function setServer_IP($server_ip){
            $this->server_ip = $server_ip;
    }

    public function getServer_IP(){
            return $this->server_ip;
    }

    public function setRemote_IP($Remote_ip){
            $this->remote_ip = $remote_ip;
    }

    public function getRemote_IP(){
            return $this->remote_ip;
    }

    public function setPath($path){
        $s = explode("?", $path); //divide path from query string
        $this->path = explode("/", $s[0]); // separate path into array
    }

    public function getPath(){
        return $this->path;
    }

    public function setParams($paramsString)
    {
        parse_str($paramsString, $paramsArray);
            $this->params = $paramsArray;
    }

    public function getParameters(){
            return $this->params;
    }

    public function getBody() {
        return $this->body;
    }

    public function isValid() {
            return $this->isValid;
    }

    public function setValid($validate) {

        $this->isValid = $validate;
    }

    public function setResponseCode($code)
    {
    $this->response = $code;
    }

    public function getReponseCode() {
        return $this->response;
    }

}
