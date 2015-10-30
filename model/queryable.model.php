<?php

include_once ROOT_REST_DIR . "/database/executer.db.php";
include_once ROOT_REST_DIR . "/database/connector.db.php";

class QueryableResource
{
    var $name;
    var $parameters;
    var $method;
    var $db_executer;
    var $db_connector;

    public function __construct($name, $parameters, $method)
    {
        self::create_db_connector();
        self::create_db_executer();
        self::set_name($name);
        self::set_parameters($parameters);
        self::set_method($method);
    }

    private function create_db_executer()
    {
        $this->db_executer = new DatabaseExecuter();
    }

    private function create_db_connector()
    {
        $this->db_connector = new DatabaseConnector();
    }

    public function get_name()
    {
        return $this->name;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function get_parameters()
    {
        return $this->parameters;
    }

    public function set_parameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function get_method()
    {
        return $this->method;
    }

    public function set_method($method)
    {
        $this->method = $method;
    }

    public function get_table_name()
    {
        $select_table_name = "SELECT RESOURCE_NAME FROM META_RESOURCE WHERE RESOURCE_FRIENDLY_NAME = '$this->name';";
        $result            =  $this->db_executer->execute($select_table_name, $this->db_connector->get_PDO_object());
        return $result[0]["RESOURCE_NAME"];
    }

    public function get_all_columns()
    {
        $resource_id    = self::get_resource_id($this->name);
        $select_columns = "SELECT META_PROPERTY.PROPERTY_NAME FROM META_PROPERTY WHERE META_PROPERTY.RESOURCE_ID = '$resource_id' ";
        $result         =  $this->db_executer->execute($select_columns, $this->db_connector->get_PDO_object());
        return $result;
    }

    public function get_resource_id()
    {
        $select_id     = "SELECT META_RESOURCE.RESOURCE_ID FROM META_RESOURCE WHERE UPPER(RESOURCE_FRIENDLY_NAME) = UPPER('$this->name');";
        $result        =  $this->db_executer->execute($select_id, $this->db_connector->get_PDO_object());
        return $result[0]["RESOURCE_ID"];
    }

    public function get_column_name($friendly_name, $id)
    {
        $select_columns = "SELECT META_PROPERTY.PROPERTY_NAME FROM META_PROPERTY WHERE UPPER(META_PROPERTY.PROPERTY_FRIENDLY_NAME) = UPPER('$friendly_name') AND META_PROPERTY.RESOURCE_ID = '$id' ";
        $result         =  $this->db_executer->execute($select_columns, $this->db_connector->get_PDO_object());
        if(empty($result))
            return null; //TODO: exception class
        return $result[0]["PROPERTY_NAME"];
    }

    private function parameters_to_sql_format($parameters, $simbol)
    {
        $size = count($parameters);
        $counter = 0;

        $final_string = "";
        foreach($parameters as $key => $value)
        {
            if(++$counter === $size) {
                $final_string = $final_string . $key . " = '" . $value. "'";
            } else {
                $final_string = $final_string.$key." = '".$value. "' $simbol ";
            }
        }
        return $final_string;
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

    public function get_all_resource_columns()
    {
        return self::columns_to_sql_format(self::get_all_columns());
    }

    private function get_resource_columns_by_params()
    {
        $sql_columns = array();
        foreach($this->parameters as $key => $value)
        {
            $column_name = self::get_column_name($key, self::get_resource_id());
            if(!is_null($column_name))
                $sql_columns[$column_name] = $value;
        }
        return $sql_columns;
    }

    public function get_resource_columns()
    {
        return self::parameters_to_sql_format(self::get_resource_columns_by_params(), SQL::E);
    }

    public function get_parameters_values()
    {
        $size = count($this->parameters);
        $counter = 0;

        $sql = "(";
        foreach($this->parameters as $value)
        {
            if(++$counter == $size)
                $sql = $sql.$value.")";
            else
                $sql = $sql.$value.",";
        }

        return $sql;
    }

    public function get_parameters_without_id()
    {
        $sql_columns = array();
        foreach($this->parameters as $key => $value)
        {
            $column_name = self::get_column_name($key, self::get_resource_id());
            if(!is_null($column_name))
                if($key !== 'id')
                    $sql_columns[$column_name] = $value;
        }
        return self::parameters_to_sql_format($sql_columns, SQL::COMA);
    }

    public function get_id_value()
    {
        if(!array_key_exists('id', $this->parameters))
        {
            return new HTTPStatus(400, "Bad request: the id was not specified");
        }

        return self::get_column_name('id', self::get_resource_id())." = ".$this->parameters['id'];
    }


}

