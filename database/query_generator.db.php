<?php

//include_once ROOT_REST_DIR . "/properties/querys.properties.php";

class QueryGenerator
{
	//var $device_querys;

	public function __construct()
	{
		//global $device_querys;
		//$this->device_querys = $device_querys;
	}

	public function get_uri_query($uri)
	{
		//first element of uri is always resource
		switch($uri[0])
		{
			case "device":
					return self::get_device_query($uri);
			case "service":
					return self::get_service_query($uri);
			case "action":
					return self::get_action_query($uri);
			case "slave_controller":
					return self::get_slave_controller_query($uri);
			case "state_variable":
					return self::get_slave_controller_query($uri);
			case "resource":
					return self::get_resource_query($uri);								
			default: 
					return NULL;		
		}
	}

	public function get_parameters_query($parameters, $resource)
	{

	}

	private function get_device_query($uri)
	{
		switch(sizeof($uri))
        {
            case 1:
                return "SELECT PK_Id,TE_UDN,FK_Slave_Controller,TE_Friendly_Name,TE_Device_Type FROM device WHERE BO_Deleted = 0";

            case 2:
                return "SELECT PK_Id,TE_UDN,FK_Slave_Controller,TE_Friendly_Name,TE_Device_Type FROM device WHERE PK_Id =
					   '" . $uri[1] . "';"; //WHERE BO_Deleted = 0
            case 3:
                return "SELECT PK_Id, TE_Friendly_Name, TE_Service_Id, TE_Service_Type, TE_Description
				FROM service WHERE FK_Device = '" . $uri[1] . "';"; //WHERE BO_Deleted = 0

            default:
            	return NULL;
		}
	}

	private function get_service_query($uri)
	{
		switch(sizeof($uri))
        {
            case 1:
                return ;

            case 2:
                return ;
            case 3:
                return;

            default:
            	return NULL;
		}
	}

	private function get_action_query($uri)
	{
		switch(sizeof($uri))
        {
            case 1:
                return "SELECT PK_Id,TE_Name,FK_Service FROM action WHERE BO_Deleted = 0";

            case 2:
                return "SELECT PK_Id,TE_Name,FK_Service FROM action WHERE PK_Id =
					   '" . $uri[1] . "' AND BO_Deleted = 0";
            case 3:
                return;

            default:
            	return NULL;
		}
	}

	private function get_slave_controller_query($uri)
	{
		switch(sizeof($uri))
        {
            case 1:
                return ;

            case 2:
                return ;
            case 3:
                return ;

            default:
            	return NULL;
		}
	}

	private function get_state_variables_query($uri)
	{
		switch(sizeof($uri))
        {
            case 1:
                return ;
            case 2:
                return ;
            case 3:
                return ;

            default:
            	return NULL;
		}
	}
}	
