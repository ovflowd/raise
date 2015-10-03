<?php

include_once ROOT_REST_DIR . "/resources/slave_controller/control/slaveController.control.php";
include_once ROOT_REST_DIR . "/resources/device/control/deviceController.control.php";
include_once ROOT_REST_DIR . "/resources/service/control/serviceController.control.php";
include_once ROOT_REST_DIR . "/resources/action/control/actionController.control.php";
include_once ROOT_REST_DIR . "/resources/state_variable/control/stateVariableController.control.php";
include_once ROOT_REST_DIR . "/database/resourceController.db.php"; 

/**
 * Class ResourceController
 */
final class ResourceController
{
    var $slave_controller;
    var $device_controller;
    var $service_controller;
    var $action_controller;
    var $state_var_controller;
    var $db_resource_controller;

    public function __construct()
    {
        self::start_controllers();
    }

    private function start_controllers()
    {
        $this->slave_controller     = new SlaveController();
        $this->device_controller    = new DeviceController();
        $this->service_controller   = new ServiceController();
        $this->action_controller    = new ActionController();
        $this->state_var_controller = new StateVariableController();
        $this->db_resource_controller = new DBResourceController();

    }

    public function get_slave_controller()
    {
        return $this->slave_controller;
    }

    public function get_device_controller()
    {
        return $this->device_controller;
    }

    public function get_service_controller()
    {
        return $this->service_controller;
    }

    public function get_action_controller()
    {
        return $this->action_controller;
    }

    public function get_state_var_controller()
    {
        return $this->state_var_controller;
    }

    public function execute_request($uri, $connection) 
    {
       
        switch ($uri[1]) {
            case 'device':
                    return $this->db_resource_controller->select_all_device_fields($connection);            
            default:
                return "";
        }
    }
}