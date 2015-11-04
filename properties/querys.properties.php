<?php

function select_all_devices()
{
    return "SELECT * FROM DEVICE";
}

function select_all_services()
{
    return "SELECT * FROM SERVICE";
}

function select_all_actions()
{
    return "SELECT * FROM ACTION";
}

function select_all_slave_controllers()
{
    return "SELECT * FROM SLAVER_CONTROLLER";
}

function select_all_state_variables()
{
    return "SELECT * FROM STATE_VARIABLE";
}

function select_all_resources()
{
    return "SELECT RESOURCE_NAME FROM META_RESOURCE";
}


//querys select by id
function select_device_by_id($id)
{
    return "SELECT * FROM DEVICE WHERE id = '{$id}';";
}

function select_service_by_id()
{
    return "SELECT * FROM SERVICE WHERE id = '{$id}';";
}

function select_action_by_id()
{
    return "SELECT * FROM ACTION WHERE id = '{$id}';";
}

function select_slave_controller_by_id()
{
    return "SELECT * FROM SLAVER_CONTROLLER WHERE id = '{$id}';";
}

function select_state_variable_by_id()
{
    return "SELECT * FROM STATE_VARIABLE WHERE id = '{$id}';";
}

function select_resource_by_id()
{
    return "SELECT * FROM RESOURCE WHERE id = '{$id}';";
}


//querys select associeted resource
function select_device_services($device_id)
{
    return "SELECT * FROM SERVICE WHERE DEVICE_ID = '{$device_id}';";
}

function select_service_actions($service_id)
{
    return "SELECT * FROM ACTION WHERE SERVICE_ID = '{$service_id}';";
}

function select_service_state_variables($service_id)
{
    return "SELECT * FROM STATE_VARIABLE WHERE SERVICE_ID = '{$service_id}';";
}


