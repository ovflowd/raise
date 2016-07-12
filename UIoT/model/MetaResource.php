<?php

namespace UIoT\model;

/**
 * Class MetaResource
 * @package UIoT\model
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
     * @param mixed $properties
     */
    public function __construct($id, $acronym, $name, $friendlyName, $properties)
    {
        $this->id = $id;
        $this->acronym = $acronym;
        $this->name = $name;
        $this->friendlyName = $friendlyName;
        $this->properties = $properties;
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
     * @param MetaProperty[] $properties
     */
    public function addProperties($properties)
    {
        foreach ($properties as $property)
            $this->addProperty($property);
    }

    /**
     * @param MetaProperty $property
     */
    public function addProperty(MetaProperty $property)
    {
        $this->properties[] = $property;
    }

    /**
     * @param $selectedColumns
     * @return array
     */
    public function getColumnNamesByQuery($selectedColumns)
    {
        $names = array();

        foreach ($this->properties as $property) {
            if (in_array($property->getFriendlyName(), $selectedColumns)) {
                $names[] = $property->getPropertyName();
            }
        }

        return $names;
    }

    /**
     * @return array
     */
    public function getColumnNames()
    {
        $names = array();

        foreach ($this->properties as $property) {
            $names[] = $property->getPropertyName();
        }

        return $names;
    }

    /**
     * @return array
     */
    public function getColumnFriendlyNames()
    {
        $names = array();

        foreach ($this->properties as $property) {
            $names[$property->getPropertyName()] = $property->getFriendlyName();
        }

        return $names;
    }

    /**
     * @param $friendlyName
     * @return MetaProperty
     */
    public function getProperty($friendlyName)
    {
        foreach ($this->properties as $property) {
            if ($property->getFriendlyName() === $friendlyName) {
                return $property;
            }
        }

        return null;
    }
}