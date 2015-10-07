<?php

include_once ROOT_REST_DIR . "/control/request.control.php";
include_once ROOT_REST_DIR . "/util/request_router.util.php";

/**
 * Class RequestInput
 */
class RequestInput
{
    var $request_control;
    var $request_router;

    public function __construct()
    {
        self::set_request_control(new RequestControl());
        self::set_request_router(new RequestRouter());
    }

    public function start()
    {
        return self::submit_request();
    }

    private function set_request_control($request_control)
    {
        $this->request_control = $request_control;
    }

    private function set_request_router($request_router)
    {
        $this->request_router = $request_router;
    }

    private function submit_request()
    {
        $request_object = self::create_request_object();

        if (self::is_valid($request_object))
            return $this->request_router->submit_request($request_object);
        else
            return json_encode(new HTTPStatus(400), JSON_PRETTY_PRINT);
    }

    private function create_request_object()
    {
        return $this->request_control->create_request(self::get_request_uri(), 
                                                        self::get_request_method(), 
                                                        self::get_request_protocol(), 
                                                        self::get_request_script_name());
    }

    private function get_request_uri()
    {
        return explode('/', $_SERVER['REQUEST_URI']);
    }

    private function get_request_script_name()
    {
        return explode('/', $_SERVER['SCRIPT_NAME']);
    }

    private function get_request_method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function get_request_protocol()
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    private function is_valid($request)
    {
        return $this->request_control->is_valid($request);
    }
}