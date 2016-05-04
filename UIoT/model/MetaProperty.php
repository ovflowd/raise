<?php

namespace UIoT\model;

/**
 * Class MetaProperty
 * @package UIoT\model
 *
 * @property int $id
 * @property string $name
 * @property string $friendlyName
 */
class MetaProperty
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $friendlyName;

    /**
     * UIoTProperty constructor.
     * @param int $id
     * @param string $name
     * @param string $friendlyName
     */
    public function __construct($id, $name, $friendlyName)
    {
        $this->id=$id;
        $this->name=$name;
        $this->friendlyName=$friendlyName;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFriendlyName()
    {
        return $this->friendlyName;
    }




}