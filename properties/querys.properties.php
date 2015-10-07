<?php

//querys select all <resource>
function select_all_devices() 
{
	return "SELECT PK_Id,TE_UDN,FK_Slave_Controller,TE_Friendly_Name,TE_Device_Type FROM device WHERE BO_Deleted = 0";
}

// $select_all_services = ;

// $select_all_actions = ;

// $select_all_slave_controllers = ;

// $select_all_state_variables = ;

// $select_all_resources = ;


//querys select by id
function select_device_by_id($id)
{
	return "SELECT PK_Id,TE_UDN,FK_Slave_Controller,TE_Friendly_Name,TE_Device_Type FROM device WHERE PK_Id
	 		= '{$id}';";
}

// $select_service_by_id = ;

// $select_action_by_id = ;

// $select_slave_controller_by_id = ;

// $select_state_variable_by_id = ;

// $select_resource_by_id = ;


//querys select associeted resource
function select_device_services($device_id)
{
	return "SELECT PK_Id, TE_Friendly_Name, TE_Service_Id, TE_Service_Type, TE_Description
			FROM service WHERE FK_Device = '{$device_id}';";
}

// $select_service_actions = ;

// $select_service_state_variables = ;

// $device_querys = array("all" => $select_all_devices, "by-id" => $select_device_by_id, 
// 					   "services" => $select_device_services);



// $querys = array("device" => $device_querys());