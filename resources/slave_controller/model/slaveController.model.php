<?php

/**
 * Class SlaveController
 */
class SlaveController
{
    var $name;
    var $type;
    var $address;
    var $description;

    function get_name()
    {
        return $this->name;
    }

    function set_name($name)
    {
        $this->name = $name;
    }

    function get_type()
    {
        return $this->type;
    }

    function set_type($type)
    {
        $this->type = $type;
    }

    function get_address()
    {
        return $this->address;
    }

    function set_address($address)
    {
        $this->address = $address;
    }

    function get_description()
    {
        return $this->description;
    }

    function set_description($description)
    {
        $this->description = $description;
    }
}