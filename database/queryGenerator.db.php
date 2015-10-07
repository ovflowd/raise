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
		switch($uri[0])
		{
			case "device":
					return self::get_device_query($uri);
			case "service":
					return self::get_service_query($uri);		
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
}	
