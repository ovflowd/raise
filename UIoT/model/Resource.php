<?php

namespace UIoT\model;
use UIoT\sql\SQLFilter;
use UIoT\sql\SQLSelect;
use UIoT\sql\SQLWords;
use UIoT\sql\SQLCriteria;


/**
 * Class MetaResource
 * @package UIoT\model
 */

class Resource
{

    private $table_name;
    private $instruction;
    private $parameters;



    /**
     * method __construct
     * instantiates a new Resource
     * @param $table_name : string
     * @param $instruction : SQLInstruction
     * @param $parameters : string
     *
     */
    public function __construct($table_name, $instruction, $parameters)
    {
        $this->set_table_name($table_name);
    }

    /**
     * method set_table_name
     * sets table_name value
     * @param $resource_name : string
     *
     */
    public function set_table_name($table_name)
    {

    }

}


