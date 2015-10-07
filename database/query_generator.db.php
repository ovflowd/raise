<?php

include_once ROOT_REST_DIR . "/properties/querys.properties.php";
include_once ROOT_REST_DIR . "/model/http_status.model.php";


//this class nedd refactoring based on resources (model,control, db)
//should not be implemented based on URI
class QueryGenerator
{

	public function get_uri_query($uri)
	{
		switch(sizeof($uri))
        {
            case 1:
                return self::get_all($uri);

            case 2:
                return self::get_by_id($uri);

             case 3:
             	return self::get_associeted_resource($uri);

            default:
            	return json_encode(new HTTPStatus(400), JSON_PRETTY_PRINT);
		}
	}

	public function get_parameters_query($parameters, $resource)
	{
		//TODO
	}

	private function get_all($uri)
	{
		switch($uri[0])
		{
			case "device":
					return select_all_devices();
			case "service":
					return select_all_services();
			case "action":
					return select_all_actions();
			case "slave_controller":
					return select_all_slave_controllers();
			case "state_variable":
					return select_all_state_variables();
			case "resource":
					return select_all_resources();								
			default: 
					return json_encode(new HTTPStatus(404), JSON_PRETTY_PRINT);		
		}
	}

	public function get_by_id($uri)
	{
		switch($uri[0])
		{
			case "device":
					return select_device_by_id($uri[1]);
			case "service":
					return select_service_by_id($uri[1]);
			case "action":
					return select_action_by_id($uri[1]);
			case "slave_controller":
					return select_slave_by_id($uri[1]);
			case "state_variable":
					return select_state_var_by_id($uri[1]);
			case "resource":
					return select_resource_by_id($uri[1]);								
			default: 
					return json_encode(new HTTPStatus(404), JSON_PRETTY_PRINT);			
		}
	}

		public function get_by_id($uri)
	{
		switch($uri[0])
		{
			case "device":
					return select_device_by_id($uri[1]);
			case "service":
					return select_service_by_id($uri[1]);
			case "action":
					return select_action_by_id($uri[1]);
			case "slave_controller":
					return select_slave_by_id($uri[1]);
			case "state_variable":
					return select_state_var_by_id($uri[1]);
			case "resource":
					return select_resource_by_id($uri[1]);								
			default: 
					return json_encode(new HTTPStatus(404), JSON_PRETTY_PRINT);			
		}
	}


	public function get_associeted_resource($uri)
	{
		switch($uri[0])
		{
			case "device":
					return select_device_services($uri[1]);
			case "service":
					return select_service_actions($uri[1]);
			case "slave_controller":
					return select_slave_devices($uri[1]);								
			default: 
					return json_encode(new HTTPStatus(404), JSON_PRETTY_PRINT);			
		}
	}

}	
