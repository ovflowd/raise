<?php

/**
 * UIoT Service Layer
 * @version alpha
 *                          88
 *                          ""              ,d
 *                                          88
 *              88       88 88  ,adPPYba, MM88MMM
 *              88       88 88 a8"     "8a  88
 *              88       88 88 8b       d8  88
 *              "8a,   ,a88 88 "8a,   ,a8"  88,
 *               `"YbbdP'Y8 88  `"YbbdP"'   "Y888
 *
 * @author Universal Internet of Things
 * @license MIT <https://opensource.org/licenses/MIT>
 * @copyright University of Brasília
 */

namespace UIoT\Models;

use UIOT\Factories\PropertyFactory;
use UIoT\Interfaces\ResourceInterface;

/**
 * Class ResourceModel
 * @package UIoT\Models
 */
class ResourceModel implements ResourceInterface
{
    /**
     * Resource Unique Identifier
     *
     * @var int
     */
    public $ID;

    /**
     * Resource Unique Acronym
     *
     * @var string
     */
    public $RSRC_ACRONYM;

    /**
     * Resource Internal Name
     *
     * @var string
     */
    public $RSRC_NAME;

    /**
     * Resource Friendly Name
     *
     * @var string
     */
    public $RSRC_FRIENDLY_NAME;

    /**
     * Resource Properties
     *
     * The Resource Properties is a Factory
     *
     * @var PropertyFactory
     */
    private $resourceProperties;

    /**
     * Return the Resource Shorthand tag identifier <RSRC_ACRONYM>
     *
     * The Resource Acronym is the short tag identifier for a Resource,
     * and is not important for the `client`. Only useful for internal storage.
     *
     * Generally the Acronym is a four character digit string, but can variate from 3 to 5 digits.
     * Only characters are allowed in a Acronym tag. Not numbers allowed.
     *
     * @return string
     */
    public function getAcronym()
    {
        return $this->RSRC_ACRONYM;
    }

    /**
     * Return the Resource Internal Name <RSRC_NAME>
     *
     * This name is only used for internal SQL Operations, and is not available
     * or readable to the `client`
     *
     * @return string
     */
    public function getInternalName()
    {
        return $this->RSRC_NAME;
    }

    /**
     * Return the Resource Friendly Name <RSRC_FRIENDLY_NAME>
     *
     * The Resource Friendly Name is the public identification that a `client` can get
     * from a specific Resource. RAISE will only accept from a `client` a Resource Friendly Name
     * for Resource Identification.
     *
     * Also only the Resource Friendly Name is answered for the `client`, since the Internal Name <RSRC_NAME>
     * isn't a public identification.
     *
     * @return string
     */
    public function getFriendlyName()
    {
        return $this->RSRC_FRIENDLY_NAME;
    }

    /**
     * Return the Properties from the Resource
     *
     * The Properties are stored inside a Resource and only Populated
     * after the Instantiation of the Resource Model
     *
     * @return PropertyFactory
     */
    public function getProperties()
    {
        if (null === $this->resourceProperties) {
            $this->resourceProperties = new PropertyFactory($this->getId());
        }

        return $this->resourceProperties;
    }

    /**
     * Return the Resource Unique Identifier <ID>
     *
     * The identifier is stored in `META_RESOURCES` Database Table
     *
     * @return int
     */
    public function getId()
    {
        return $this->ID;
    }
}
