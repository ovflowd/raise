<?php

include ROOT_REST_DIR . "/model/request.model.php";

/**
 * Class RequestControl
 */
class RequestControl
{
    var $request;

    public function __construct()
    {
        $this->request = NULL;
    }

    public function create_request($request_uri, $request_method, $server_protocol, $script_name)
    {
        $request = new Request($request_uri, $request_method, $server_protocol, $script_name);
        return $request;
    }
}