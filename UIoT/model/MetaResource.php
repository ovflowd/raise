<?php

namespace UIoT\model;

/**
 * Class MetaResource
 * @package UIoT\model
 */
class MetaResource
{
    /**
     * @var int Resource Id
     */
    private $resourceId;

    /**
     * @var string Resource Acronym
     */
    private $resourceAcronym;

    /**
     * @var string Resource Name
     */
    private $resourceName;

    /**
     * @var string Resource Friendly Name
     */
    private $friendlyName;

    /**
     * @var MetaProperty[] Resource Properties
     */
    private $resourceProperties = [];

    /**
     * Create a new UIoT Resource
     *
     * @param int $resId
     * @param string $acronym
     * @param string $resName
     * @param string $friendlyName
     */
    public function __construct($resId, $acronym, $resName, $friendlyName)
    {
        $this->resourceId = $resId;
        $this->resourceAcronym = $acronym;
        $this->resourceName = $resName;
        $this->friendlyName = $friendlyName;
    }

    /**
     * Get Resource Acronym
     *
     * @return string
     */
    public function getAcronym()
    {
        return $this->resourceAcronym;
    }

    /**
     * Get Resource Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->resourceName;
    }

    /**
     * Get Resource Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->resourceId;
    }

    /**
     * Add a set of properties to a Resource
     *
     * @param MetaProperty[] $properties
     */
    public function addProperties($properties)
    {
        foreach ($properties as $property) {
            $this->addProperty($property);
        }
    }

    /**
     * Add a single Property to a Resource
     *
     * @param MetaProperty $property
     */
    public function addProperty(MetaProperty $property)
    {
        $this->resourceProperties[$property->getName()] = $property;
    }

    /**
     * Get a set of Properties filtered by an array of Friendly Names
     *
     * @param string[] $namesArray
     * @return MetaProperty[]
     */
    public function getPropertiesByNames(array $namesArray)
    {
        return array_filter($this->getProperties(), function ($property) use ($namesArray) {
            /** @var $property MetaProperty */
            return in_array($property->getFriendlyName(), array_keys($namesArray));
        });
    }

    /**
     * Get Resource Properties
     *
     * @return MetaProperty[]
     */
    public function getProperties()
    {
        return $this->resourceProperties;
    }

    /**
     * Get an array containing all Properties Names
     *
     * @return string[]
     */
    public function getPropertiesNames()
    {
        return array_map(function ($property) {
            /** @var $property MetaProperty */
            return $property->getName();
        }, $this->getProperties());
    }

    /**
     * Get an array containing all Properties Friendly Names
     *
     * @return string[]
     */
    public function getPropertiesFriendlyNames()
    {
        return array_map(function ($property) {
            /** @var $property MetaProperty */
            return $property->getFriendlyName();
        }, $this->getProperties());
    }

    /**
     * Get Resource Friendly Name
     *
     * @return string
     */
    public function getFriendlyName()
    {
        return $this->friendlyName;
    }

    /**
     * Get a specific Resource Property by a Friendly Name
     *
     * @param string $friendlyName
     * @return MetaProperty
     */
    public function getProperty($friendlyName)
    {
        return reset(array_filter($this->getProperties(), function ($property) use ($friendlyName) {
            /** @var $property MetaProperty */
            return $property->getFriendlyName() === $friendlyName;
        }));
    }
}