<?php

/**
 * Class Request
 */
class Request
{
    var $uri;
    var $resource;
    var $parameters;
    var $type;
    var $protocol;
    var $script_name;

    public function __construct($uri, $type, $protocol, $script_name)
    {
        self::set_type($type);
        self::set_script_name($script_name);
        self::set_protocol($protocol);
        self::set_uri(self::prepare_uri($uri));
        self::set_resource($uri);
        self::set_parameters($uri);
    }

    private function prepare_uri($raw_uri)
    {
        $tmp_uri = self::remove_script_parameters($raw_uri);
        return self::remove_uri_parameters($tmp_uri);
    }

    private function remove_script_parameters($uri)
    {
        for ($i = 0; $i < sizeof($this->script_name); $i++) {
            if ($uri[$i] == $this->script_name[$i]) {
                unset($uri[$i]);
            }
        }

        //return a uri_array with no empty elements
        return array_filter(array_values($uri)); 
    }

    private function remove_uri_parameters($uri)
    {
        $last_uri_element = reset(explode('?', end($uri)));
        end($uri);
        $uri[key($uri)] = $last_uri_element;
        return $uri;
    }

    private function set_parameters($uri)
    {
        $this->parameters = self::set_parameters_map($uri);
    }

    private function set_parameters_map($uri)
    {
        $string_parameters = self::get_uri_parameters_as_string(end($uri));
        
        if($string_parameters !== "")
            return self::get_uri_parameters_as_array($string_parameters);
         
        return NULL;
    }

    private function get_uri_parameters_as_array($string_parameters)
    {
        $parameters = array();
        $tmp_array = explode('&', $string_parameters);
        
        foreach($tmp_array as $parameter) 
        {
            $key_value_parameter = explode("=", $parameter);
            $parameters[$key_value_parameter[0]] = $key_value_parameter[1];
        }

        return $parameters;  
    }

    private function get_uri_parameters_as_string($raw_string_parameters)
    {
        //if first element is different from '?' or if '?' is not included on string
        if (!strpos($raw_string_parameters, '?') === 0 || strpos($raw_string_parameters, '?') === FALSE) {
            return ""; 
        }
        //return all parameters as string without character '?'
        return end(explode('?', $raw_string_parameters)); 
    }

    public function get_uri()
    {
        return $this->uri;
    }

    private function set_uri($uri)
    {
        $this->uri = $uri;
    }

    public function get_resource()
    {
        return $this->resource;
    }

    private function set_resource($uri)
    {
        $this->resource = self::get_uri()[0];
    }

    public function get_parameters()
    {
        return $this->parameters;
    }

    public function get_type()
    {
        return $this->type;
    }

    private function set_type($type)
    {
        $this->type = $type;
    }

    public function get_protocol()
    {
        return $this->protocol;
    }

    private function set_protocol($protocol)
    {
        $this->protocol = $protocol;
    }

    public function get_script_name()
    {
        return $this->script_name;
    }

    private function set_script_name($script_name)
    {
        $this->script_name = $script_name;
    }

    public function has_parameters()
    {
        if(self::get_parameters() == NULL) 
            return false;
        
        return true;
    }

    public function has_composed_uri()
    {
        if(sizeof(self::get_uri()) > 1)
            return true;
        
        return false;
    }
}