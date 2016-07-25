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

namespace UIoT\Managers;

use UIoT\Interfaces\InteractionInterface;
use UIoT\Models\InteractionModel;

/**
 * Class InteractionManager
 * @package UIoT\Managers
 */
class InteractionManager
{
    /**
     * Path to RAISe Interactions
     *
     * @var string
     */
    private $interactionsNamespace = 'UIoT\Interactions\\';

    /**
     * RAISe Interaction List
     *
     * @var InteractionInterface[]
     */
    private $calledInteractions = array();

    /**
     * Get Interaction Manager Instance
     *
     * @return InteractionManager
     */
    public static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Return a Generic Interaction by Method Name
     * @warning if more than one Interaction has same method
     * will return the first occurrence.
     *
     * @remember Only GENERIC Interactions must be added in
     * `Register.php` file. Special Interactions are called
     * at execution time.
     *
     * @param string $methodName
     * @return InteractionModel
     */
    public function getByMethod($methodName)
    {
        return reset(array_filter($this->calledInteractions, function ($interaction) use ($methodName) {
            /** @var $interaction InteractionInterface */
            return $interaction->getMethod() == $methodName;
        }));
    }

    /**
     * Prepare's and Execute's an Interaction
     * after that Return It
     *
     * @param string $interactionName
     * @return InteractionModel
     */
    public function execute($interactionName)
    {
        $interaction = $this->get($interactionName);
        $interaction->prepare();
        $interaction->execute();

        return $interaction;
    }

    /**
     * Get a specific RAISe Interaction
     *
     * @param string $interactionName
     * @return InteractionModel
     */
    public function get($interactionName)
    {
        return !array_key_exists($interactionName, $this->calledInteractions) ? $this->add($interactionName)
            : $this->calledInteractions[$interactionName];
    }

    /**
     * Add a RAISe Interaction to Interaction List
     * @note this is good for caching
     *
     * @param string $interactionName Interaction to Add
     * @param string $interactionMethod HTTP Method
     * @return InteractionInterface
     */
    public function add($interactionName, $interactionMethod = 'GET')
    {
        $className = $this->interactionsNamespace . $interactionName;

        return class_exists($className) ? $this->calledInteractions[$interactionName] = new $className($interactionMethod)
            : null;
    }
}
