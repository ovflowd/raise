<?php

namespace UIoT\view;

use UIoT\control\RequestController;
use UIoT\util\RequestRouter;

/**
 * Class RequestInput
 * @package UIoT\view
 */
class RequestInput
{
    var $request_control;
    var $request_router;

    public function __construct()
    {
        self::set_request_control(new RequestController());
        self::set_request_router(new RequestRouter());
    }

    private function set_request_control($request_control)
    {
        $this->request_control = $request_control;
    }

    private function set_request_router($request_router)
    {
        $this->request_router = $request_router;
    }

    public function start()
    {
        return self::submit_request();
    }

    private function submit_request()
    {
        $request = self::create_request_object();

        if (self::is_valid($request))
            return $this->request_router->submit_request($request);
        else
            return $request->get_error_status();
    }

    private function create_request_object()
    {
        return $this->request_control->create_request(
            self::get_request_uri(),
            self::get_request_method(),
            self::get_request_protocol(),
            self::get_request_script_name());
    }

    private function get_request_uri()
    {
        return explode('/', $_SERVER['REQUEST_URI']);
    }

    private function get_request_method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function get_request_protocol()
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    private function get_request_script_name()
    {
        return explode('/', $_SERVER['SCRIPT_NAME']);
    }

    private function is_valid($request)
    {
        return (is_a($request, 'UIoT\model\Request') && is_null($request->get_error_status()));
    }
}