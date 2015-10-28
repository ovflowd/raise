<?php

include_once ROOT_REST_DIR . "/database/connector.db.php";
include_once ROOT_REST_DIR . "/database/executer.db.php";
include_once ROOT_REST_DIR . "/properties/sql.properties.php";
include_once ROOT_REST_DIR . "/model/queryable.model.php";

class QueryableController
{
    var $db_connector;
    var $db_executer;

    public function __construct()
    {
        self::create_db_controller();
        self::create_db_executer();
    }

    private function create_db_controller()
    {
        $this->db_connector = new DatabaseConnector();
    }

    private function create_db_executer()
    {
        $this->db_executer = new DatabaseExecuter();
    }

    public function generate_query($resource_name, $parameters, $method)
    {
        return self::resource_to_query(self::create_resource($resource_name, $parameters, $method));

    }

    public function create_resource($resource_name, $parameters, $method)
    {
        try {
            $resource =  new QueryableResource($resource_name, $parameters, $method);
            return $resource;
        } catch (Exception $e) {
            return json_encode(new HTTPStatus(400), JSON_PRETTY_PRINT);
        }
    }

    private function resource_to_query($resource)
    {
       return call_user_func('self::'.$resource->get_method(), $resource);
    }

    private function SELECT($resource)
    {
        return SQL::SELECT.SQL::BLANK.
               self::columns_to_sql_format(self::get_columns_names($resource)).SQL::BLANK.
               SQL::FROM.SQL::BLANK.
               self::get_table_name($resource).SQL::BLANK.
               SQL::WHERE.SQL::BLANK.
               $resource->parameters_to_sql_format();
    }

    private function INSERT($resource)
    {
        return SQL::INSERT_INTO.SQL::BLANK.self::get_table_name($resource).SQL::BLANK.self::columns_to_sql_format(self::get_columns_names($resource)).SQL::BLANK.SQL::VALUES.SQL::BLANK.$resource->parameters_to_sql_format();
    }

    private function UPDATE($resource)
    {
        return SQL::UPDATE.SQL::BLANK.self::get_table_name($resource).SQL::BLANK.SQL::SET.SQL::BLANK.$resource->parameters_to_sql_format().SQL::BLANK.SQL::WHERE.SQL::BLANK."keys_and_values";
    }

    private function DELETE($resource)
    {
        return SQL::DELETE.SQL::BLANK.SQL::FROM.SQL::BLANK.self::get_table_name($resource).SQL::BLANK.SQL::WHERE.SQL::BLANK."keys_and_values";
    }

    private function get_table_name($resource)
    {
        $friendly_name     = $resource->get_name();
        $select_table_name = "SELECT RESOURCE_NAME FROM META_RESOURCE WHERE RESOURCE_FRIENDLY_NAME = '$friendly_name';";
        $result            =  $this->db_executer->select($select_table_name, $this->db_connector->get_PDO_object());
        return $result[0]["RESOURCE_NAME"];
    }

    private function get_columns_names($resource)
    {
        $resource_id    = self::get_resource_id($resource);
        $select_columns = "SELECT META_PROPERTY.PROPERTY_NAME FROM META_PROPERTY WHERE META_PROPERTY.RESOURCE_ID = '$resource_id' ";
        $result         =  $this->db_executer->select($select_columns, $this->db_connector->get_PDO_object());
        return $result;
    }

    private function get_resource_id($resource)
    {
        $friendly_name = $resource->get_name();
        $select_id     = "SELECT META_RESOURCE.RESOURCE_ID FROM META_RESOURCE WHERE RESOURCE_FRIENDLY_NAME = '$friendly_name';";
        $result        =  $this->db_executer->select($select_id, $this->db_connector->get_PDO_object());
        return $result[0]["RESOURCE_ID"];
    }

    private function columns_to_sql_format($columns_array)
    {

        $sql = "";
        foreach($columns_array as $column)
        {
            $unique_column = array_unique($column);
            foreach($unique_column as $column_name)
               $sql =  $sql.$column_name.",";
        }
        return rtrim($sql, ",");
    }


}