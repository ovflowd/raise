<?php

/**
 * UIoT Service Layer
 * @version beta
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

use UIoT\Interfaces\FactoryInterface;

/**
 * Class FactoryModel
 * @package UIoT\Models
 */
abstract class FactoryModel implements FactoryInterface
{
    /**
     * Add a RAISE Model in the Factory Data
     *
     * Necessary the parameter must be an object.
     * And normally the Factory will in the constructor
     * add the items.
     *
     * @note The objects need be a RAISE Model
     *
     * @param object $item
     * @return void
     */
    public function add($item)
    {
        // TODO: Implement add() method.
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
     * @param object[] $items
     * @return void
     */
    public function addSet(array $items)
    {
        // TODO: Implement addSet() method.
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
     * @param string $item
     * @param array $templateEngine
     * @return object|object[]
     */
    public function get($item, array $templateEngine = array())
    {
        // TODO: Implement get() method.
    }

    /**
     * This method returns all set of Data stored in the Factory
     *
     * @return object[]|object
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }
}