<?php

include_once ROOT_REST_DIR . "/database/connector.db.php";
include_once ROOT_REST_DIR . "/control/resource.control.php";
include_once ROOT_REST_DIR . "/model/http_status.model.php";

/**
 * Class RestRouter
 */
final class RequestRouter
{
    var $db_controller;
    var $resource_controller;

    public function __construct()
    {
        self::create_db_controller();
        self::create_resource_controller();
    }

    public function submit_request($request)
    {
        return self::execute_request($request, self::get_connection());
    }

    private function create_db_controller()
    {
        $this->db_controller = new DatabaseController();
    }

    private function create_resource_controller()
    {
        $this->resource_controller = new ResourceController();
    }

    private function get_resource_controller()
    {
        return $this->resource_controller;
    }
   
    private function get_connection()
    {
        return $this->db_controller->get_PDO_object();
    }

    private function execute_request($request, $connection)
    {
        return self::get_resource_controller()->execute_request($request, $connection);
    } 
}