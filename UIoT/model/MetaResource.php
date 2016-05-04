<?php


namespace UIoT\model;
use UIoT\metadata\Resources;


/**
 * Class MetaResource
 *
 * @package UIoT\model
 *
 * @property int $id
 * @property string $acronym
 * @property string $name
 * @property string $friendlyName
 */
class MetaResource
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
     * @var MetaProperty[]
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
     * @return MetaProperty[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param MetaProperty $property
     */
    public function addProperty(MetaProperty $property)
    {
        $this->properties[] = $property;
    }

    /**
     * @param MetaProperty[] $properties
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

    public function getProperty($friendlyName)
    {
        foreach($this->properties as $property) {
            if ($property->getFriendlyName() === $friendlyName)
                return $property;
        }
    }

}