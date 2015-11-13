<?php

namespace UIoT\util;
use UIoT\control\ResourceController;

/**
 * Class RequestRouter
 * @package UIoT\util
 */
class RequestRouter
{
    var $resource_controller;
    var $request_controller;

    public function __construct()
    {
        self::create_resource_controller();
    }

    private function create_resource_controller()
    {
        $this->resource_controller = new ResourceController();
    }

    public function submit_request($request)
    {
        return self::get_resource_controller()->execute_request($request);
    }

    private function get_resource_controller()
    {
        return $this->resource_controller;
    }


}