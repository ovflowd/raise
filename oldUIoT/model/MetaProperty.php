<?php

namespace UIoT\model;

/**
 * Class MetaProperty
 * @package UIoT\model
 */
class MetaProperty
{
    /**
     * @var int Property Id
     */
    private $propertyId;

    /**
     * @var string Property Name
     */
    private $propertyName;

    /**
     * @var string Property Friendly Name
     */
    private $friendlyName;

    /**
     * UIoTProperty constructor.
     *
     * @param int $propId
     * @param string $propName
     * @param string $friendlyName
     */
    public function __construct($propId, $propName, $friendlyName)
    {
        $this->propertyId = $propId;
        $this->propertyName = $propName;
        $this->friendlyName = $friendlyName;
    }

    /**
     * Get Property Name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->propertyName;
    }

    /**
     * Get Property Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->propertyId;
    }

    /**
     * Get Property Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->propertyName;
    }

    /**
     * Get Property Friendly Name
     *
     * @return string
     */
    public function getFriendlyName()
    {
        return $this->friendlyName;
    }
}