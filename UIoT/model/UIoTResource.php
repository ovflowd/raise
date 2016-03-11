<?php


namespace UIoT\model;
use UIoT\metadata\Resources;


/**
 * Class UIoTResource
 *
 * @package UIoT\model
 *
 * @property int $id
 * @property string $acronym
 * @property string $name
 * @property string $friendlyName
 */
class UIoTResource
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $acronym;

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $friendlyName;
    /**
     * @var UIoTProperty[]
     */
    private $properties;

    /**
     * UIoTResource constructor.
     *
     * @param int $id
     * @param string $acronym
     * @param string $name
     * @param string $friendlyName
     */
    public function __construct($id, $acronym, $name, $friendlyName)
    {
        $this->id=$id;
        $this->acronym=$acronym;
        $this->name=$name;
        $this->friendlyName=$friendlyName;
    }

    /**
     * @return string
     */
    public function getAcronym()
    {
        return $this->acronym;
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

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return UIoTProperty[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param UIoTProperty $property
     */
    public function addProperty(UIoTProperty $property)
    {
        $this->properties[] = $property;
    }

    /**
     * @param UIoTProperty[] $properties
     */
    public function addProperties($properties)
    {
        foreach ($properties as $property)
            $this->addProperty($property);
    }

    public function getColumnNames()
    {
        $names = array();
        foreach ($this->properties as $property)
            $names[] = $property->getName();
        return $names;
    }



}