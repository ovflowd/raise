<?php

final class DBResourceController 
{

	public function select_all_device_fields($connection) 
	{

		$encode            = array();
        	$select_all_fields = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'device'";    
        	$result            = $connection->query($select_all_fields);

        	if ($result->rowCount() > 0) {
            		while ($row = $result->fetch()) {
                		$encode[] = $row[0];
            		}
        	}
        
		$connection = null; //destroying PDO object
        	return json_encode($encode);

	}
	
}

?>
