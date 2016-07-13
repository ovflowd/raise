<?php

namespace UIoT\model;

use stdClass;
use UIoT\util\RequestInput;

/**
 * Class ResourceController
 * @package UIoT\util
 */
class UIoTResource
{
    /**
     * @var MetaResource[] UIoT Resources
     */
    private $resources = [];

    /**
     * Creates a New SQLInstructionFactory and assign it to UIoTResource
     */
    public function __construct()
    {
        $this->setResources();
        $this->setProperties();
    }

    /**
     * Set UIoT Resources Meta Data's
     */
    private function setResources()
    {
        foreach (RequestInput::getDatabaseManager()->fetchExecute('SELECT * FROM META_RESOURCES') as $resource) {
            $this->resources[$resource->RSRC_FRIENDLY_NAME] = new MetaResource($resource->ID, $resource->RSRC_ACRONYM,
                $resource->RSRC_NAME, $resource->RSRC_FRIENDLY_NAME);
        }
    }

    /**
     * Set UIoT Resources Properties
     */
    private function setProperties()
    {
        foreach ($this->getResources() as $resource) {
            $resource->addProperties($this->populateProperties($resource));
        }
    }

    /**
     * Get Resources
     *
     * @return MetaResource[]
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Populate a specific Resource Properties
     *
     * @param MetaResource $resource
     * @return MetaProperty[]
     */
    private function populateProperties(MetaResource $resource)
    {
        $properties = array();

        foreach (RequestInput::getDatabaseManager()->fetchExecute('SELECT * FROM META_PROPERTIES WHERE RSRC_ID = :resource_id',
            [':resource_id' => $resource->getId()]) as $property) {
            $properties[] = new MetaProperty($property->ID,
                $property->PROP_NAME, $property->PROP_FRIENDLY_NAME);
        }

        return $properties;
    }

    /**
     * Change the Table with Properties Names to Friendly Names
     *
     * @param object[]|array $tableObject
     * @return array
     */
    public function propertiesToFriendlyName($tableObject)
    {
        $newTable = array();
        $resourceProperties = RequestInput::getRequest()->getResource()->getProperties();

        foreach ($tableObject as $index => $rowObjects) {
            $newTable[$index] = new stdClass();
            foreach ($rowObjects as $key => $value) {
                $newTable[$index]->{$resourceProperties[$key]->getFriendlyName()} = $value;
            }
        }

        return $newTable;
    }

    /**
     * Get friendly name from getResources array
     *
     * @return string[]
     */
    public function getResourceNames()
    {
        return array_map(function ($resource) {
            /** @var $resource MetaResource */
            return $resource->getFriendlyName();
        }, $this->getResources());
    }
}
