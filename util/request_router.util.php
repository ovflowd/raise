<?php

include_once ROOT_REST_DIR . "/database/connector.db.php";
include_once ROOT_REST_DIR . "/control/resource.control.php";
include_once ROOT_REST_DIR . "/model/http_status.model.php";

/**
 * Class RestRouter
 */
 class RequestRouter
{
    var $db_controller;
    var $resource_controller;

    public function __construct()
    {
        self::create_db_controller();
        self::create_resource_controller();
    }

    private function create_db_controller()
    {
        $this->db_controller = new DatabaseController();
    }

    private function create_resource_controller()
    {
        $this->resource_controller = new ResourceController();
    }

    public function submit_request($request)
    {
        switch ($request->get_method()) {
            case "GET":
                return self::get_resource_controller()->execute_get_request($request);
            case "POST":
                return self::get_resource_controller()->execute_post_request($request);
            case "PUT":
                return self::get_resource_controller()->execute_put_request($request);
            case "DELETE":
                return self::get_resource_controller()->execute_delete_request($request);
            default:
                return json_encode(new HTTPStatus(405), JSON_PRETTY_PRINT);
        }
    }

    private function get_resource_controller()
    {
        return $this->resource_controller;
    }


}