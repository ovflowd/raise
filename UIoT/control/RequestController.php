<?php

namespace UIoT\control;
use UIoT\model\HTTPStatus;
use UIoT\model\Request;

/**
 * Class RequestControl
 */
class RequestController
{

    var $methods = array("GET", "POST", "PUT", "DELETE");

    var $resources = array("slave_controllers", "devices", "services", "actions", "state_variables", "resources");

    public function __construct()
    {
    }

    public function create_request($request_uri, $request_method, $server_protocol, $script_name)
    {
        $request = new Request($request_uri, $request_method, $server_protocol, $script_name);
        if (!self::is_valid($request))
            $request->set_error_status(new HTTPStatus(403, null));

        return $request;
    }

    public function is_valid(Request $request)
    {
        return self::has_valid_method($request) && self::has_valid_resource($request) && self::is_uri_or_parameters_based($request);
    }

    private function has_valid_method(Request $request)
    {
        return in_array($request->get_method(), $this->methods);
    }

    private function has_valid_resource(Request $request)
    {
        return in_array($request->get_resource(), $this->resources);
    }

    private function is_uri_or_parameters_based(Request $request)
    {
        return !($request->has_parameters() && $request->has_composed_uri());
    }
}