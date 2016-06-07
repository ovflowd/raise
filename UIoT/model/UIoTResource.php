<?php

namespace UIoT\model;


/**
 * Class UIoTResource
 * @package UIoT\model
 */
class UIoTResource
{
    /**
     * @var string Name
     */
    private $name;

    /**
     * @var mixed Columns
     */
    private $columns;

    /**
     * UIoTResource constructor.
     * @param $name
     * @param $json
     */
    public function __construct($name, $json)
    {
        $this->name = $name;
        $this->columns = json_decode($json, true);
    }
}