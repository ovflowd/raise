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

namespace UIoT\Factories;

use Interfaces\FactoryInterface;
use UIoT\Interfaces\PropertyInterface;
use UIoT\Managers\DatabaseManager;
use UIoT\Mappers\Constants;
use UIoT\Mappers\Json;
use UIoT\Models\PropertyModel;

/**
 * Class PropertyFactory
 *
 * This Factory only deserves to Populate Properties
 * from Resource Models
 *
 * @package Factories
 */
class PropertyFactory implements FactoryInterface
{
    /**
     * Resource Properties
     *
     * @var PropertyInterface|PropertyInterface[]
     */
    private $resourceProperties = array();

    /**
     * Normally a RAISE Factory does'nt have any parameters
     * The Factory normally will do his business logic in a black box.
     * In other words, the Factory will request the necessary data to work
     * through the RAISE Managers
     *
     * @param int $resourceId Resource Related Identifier
     */
    public function __construct($resourceId = 0)
    {
        $raiseProperties = Json::getInstance()->convert(DatabaseManager::getInstance()->fetchAll(
            Constants::getInstance()->get('specificPropertiesQuery'), [
            ':RSRC_ID' => $resourceId
        ]), new PropertyModel);

        $this->addSet($raiseProperties);
    }

    /**
     * Add a set of RAISE Models in the Factory Data
     *
     * Necessary the parameter must be an array of objects.
     * And normally the Factory will in the constructor
     * add the items.
     *
     * @note The objects need be a RAISE Model
     *
     * @param PropertyInterface[] $items
     * @return void
     */
    public function addSet(array $items)
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * Add a RAISE Model in the Factory Data
     *
     * Necessary the parameter must be an object.
     * And normally the Factory will in the constructor
     * add the items.
     *
     * @note The objects need be a RAISE Model
     *
     * @param PropertyInterface $item
     * @return void
     */
    public function add($item)
    {
        if (!array_key_exists($item->getFriendlyName(), $this->resourceProperties)) {
            $this->resourceProperties[$item->getFriendlyName()] = $item;
        }
    }

    /**
     * This method returns an item by his identifier.
     * Normally the Factory will receive the string,
     * and route (do) the search in his Data with a specific
     * rule from the Factory.
     *
     * The templateEngine variable is useful when the Router need
     * optional parameters. In the case of MessageFactory, the templateEngine
     * parameter is used to populate variables into values passed by parameter.
     *
     * Necessary the return need be an object or array of objects.
     *
     * @param string $item Property Friendly Name
     * @param array $templateEngine
     * @return PropertyInterface|PropertyInterface[]
     */
    public function get($item, array $templateEngine = array())
    {
        return array_key_exists($item, $this->resourceProperties) ?
            $this->resourceProperties[$item] : null;
    }

    /**
     * This method returns all set of Data stored in the Factory
     *
     * @return PropertyInterface[]|PropertyInterface
     */
    public function getAll()
    {
        return $this->resourceProperties;
    }
}
