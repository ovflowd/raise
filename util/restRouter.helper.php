<?php

include_once ROOT_REST_DIR . "/properties/pages.properties.php";
include_once ROOT_REST_DIR . "/database/databaseController.db.php";
include_once ROOT_REST_DIR . "/control/resourcesController.control.php";
include_once ROOT_REST_DIR . "/model/httpStatus.model.php";

/**
 * Class RestRouter
 */
final class RestRouter
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
        global $database;
        $this->db_controller = new DatabaseController($database);
    }

    private function create_resource_controller()
    {
        $this->resource_controller = new ResourceController();
    }

    public function set_script($script)
    {
        $this->script_name = $script;
    }

    public function set_request($request)
    {
        $this->request = $request;
    }

    public function submit_request($request)
    {
        switch ($request->get_resource()) {

            case 'slave_controller' :
                return self::execute_sc_request($request, self::get_connection());

            case 'device' :
                return self::execute_device_request($request, self::get_connection());

            case 'service' :
                return self::execute_service_request($request, self::get_connection()); 

            case 'action' :
                return self::execute_action_request($request, self::get_connection());

            case 'state_variable' :
                return self::execute_state_var_request($request, self::get_connection());

            case 'resource':
                return self::execute_resource_request($request, self::get_connection());
                
            default:
                return json_encode(new HTTPStatus(404), JSON_PRETTY_PRINT);
        }
    }

    private function execute_sc_request($request, $connection)
    {
        return self::get_slave_controller()->execute_request($request->get_uri(), $request->get_type(), $connection);
    }

    private function get_slave_controller()
    {
        return self::get_resource_controller()->get_slave_controller();
    }

    private function get_resource_controller()
    {
        return $this->resource_controller;
    }

    private function get_connection()
    {
        return $this->db_controller->get_PDO_object();
    }

    private function execute_device_request($request, $connection)
    {
        return self::get_device_controller()->execute_request($request, $connection);
    }

    private function get_device_controller()
    {
        return self::get_resource_controller()->get_device_controller();
    }

    private function execute_service_request($request, $connection)
    {
        return self::get_service_controller()->execute_request($request->get_uri(), $request->get_type(), $connection);
    }

    private function get_service_controller()
    {
        return self::get_resource_controller()->get_service_controller();
    }

    private function execute_action_request($request, $connection)
    {
        return self::get_action_controller()->execute_request($request->get_uri(), $request->get_parameters(), $request->get_type(), $connection);
    }

    private function get_action_controller()
    {
        return self::get_resource_controller()->get_action_controller();
    }

    private function execute_state_var_request($request, $connection)
    {
        return self::get_state_var_controller()->execute_request($request->get_uri(), $request->get_type(), $connection);
    }

    private function get_state_var_controller()
    {
        return self::get_resource_controller()->get_state_var_controller();
    }

    private function execute_resource_request($request, $connection) 
    {
        return self::get_resource_controller()->execute_request($request->get_uri(), $connection);
    }
}