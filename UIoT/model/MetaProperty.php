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
     * @param int $id
     * @param string $name
     * @param string $friendlyName
     */
    public function __construct($id, $name, $friendlyName)
    {
        $this->propertyId = $id;
        $this->propertyName = $name;
        $this->friendlyName = $friendlyName;
    }

    /**
     * Get Property Id
     *
     * @return int
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * Get Property Name
     *
     * @return string
     */
    public function getPropertyName()
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