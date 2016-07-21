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
use UIoT\Interfaces\MessageInterface;
use UIoT\Managers\DatabaseManager;
use UIoT\Mappers\Constants;
use UIoT\Mappers\Json;
use UIoT\Models\MessageModel;

/**
 * Class MessageFactory
 *
 * @TODO: NEED URGENTLY TO THINK IN A WAY TO POPULATE ONLY THE DESIRED MESSAGE.. THE CONSTRUCTOR ALREADY FETCHES ALL ITENS
 * @TODO: ONLY THE DESIRED MESSAGE NEED BE FETCHED...
 *
 * @package UIoT\Factories
 */
class MessageFactory implements FactoryInterface
{
    /**
     * Raise Message Model Data Set
     *
     * All RAISE Messages are stored Here.
     *
     * @var MessageInterface[]
     */
    private $raiseMessages = array();

    /**
     * Normally a RAISE Factory does not have any parameters
     * The Factory normally will do its business logic in a black box.
     * In other words, the Factory will request the necessary data to work
     * through the RAISE Managers
     */
    public function __construct()
    {
        $raiseMessages = Json::getInstance()->convert($this->collectData(DatabaseManager::getInstance()->fetchAll(
            Constants::getInstance()->get('raiseMessagesQuery'))), new MessageModel);

        $this->addSet($raiseMessages);
    }

    /**
     * This method Collects the Data from the MySQL Response
     * and create an unified object for each item through
     * the MySQL GROUP BY and GROUP_CONCAT functions.
     *
     * @param array $databaseResponse Database Fetch Array
     * @return array Combined Objects
     */
    private function collectData(array $databaseResponse)
    {
        return array_map(function ($messageSet) {
            $class = (object)array_combine(explode(',', $messageSet->_NAME), explode(',', $messageSet->_VALUE));
            $class->ID = $messageSet->ID;
            return $class;
        }, $databaseResponse);
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
     * @param MessageInterface[] $items
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
     * @param MessageInterface $item
     * @return void
     */
    public function add($item)
    {
        if (!array_key_exists($item->getId(), $this->raiseMessages)) {
            $this->raiseMessages[$item->getId()] = $item;
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
     * @param string $item
     * @param array $templateEngine
     * @return MessageInterface[]|MessageInterface
     */
    public function get($item, array $templateEngine = array())
    {
        return array_key_exists($item, $this->raiseMessages) ?
            $this->applyTemplate($this->raiseMessages[$item], $templateEngine) : null;

    }

    /**
     * Applies a Simple Template Engine in the message properties
     * A specific set of properties from the Message Model
     * are replace by the values provided in the TemplateEngine array.
     *
     * @example Change the `token` variable to a real Token Hash
     *
     * @param MessageInterface $message
     * @param array $templateEngine
     * @return MessageInterface
     */
    private function applyTemplate(MessageInterface $message, array $templateEngine = array())
    {
        foreach ($templateEngine as $key => $value) {
            $message->__set($key, $value);
        }

        return $message;
    }

    /**
     * This method returns all set of Data stored in the Factory
     *
     * @return MessageInterface[]|MessageInterface
     */
    public function getAll()
    {
        return $this->raiseMessages;
    }
}
