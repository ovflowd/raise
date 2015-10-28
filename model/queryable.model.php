<?php

class QueryableResource
{
    var $name;
    var $parameters;
    var $method;

    public function __construct($name, $parameters, $method)
    {
        self::set_name($name);
        self::set_parameters($parameters);
        self::set_method($method);
    }

    /**
     * @return mixed
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function set_name($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function get_parameters()
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     */
    public function set_parameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function get_method()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function set_method($method)
    {
        $this->method = $method;
    }

    public function parameters_to_sql_format()
    {
        $size = count($this->parameters);
        $counter = 0;

        $final_string = "";
        foreach($this->parameters as $key => $value)
        {
            if(++$counter === $size) {
                $final_string = $final_string . $key . " = '" . $value. "'";
            } else {
                $final_string = $final_string.$key." = '".$value. "' AND ";
            }

        }

        return $final_string;
    }

}

