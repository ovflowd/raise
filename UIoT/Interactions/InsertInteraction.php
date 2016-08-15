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

namespace UIoT\Interactions;

use UIoT\Managers\InteractionManager;
use UIoT\Managers\RaiseManager;
use UIoT\Models\InteractionModel;

/**
 * Class InsertInteraction
 * @package UIoT\Interactions
 */
class InsertInteraction extends InteractionModel
{
    /**
     * Does the Interactions Business Logic
     * and stores in an internal Variable;
     *
     * Necessary the business logic and logical operations
     * happens in this method.
     *
     * @param string $httpMethod Interaction HTTP Method
     * @note SearchInteraction uses HTTP Get Method
     */
    public function __construct($httpMethod)
    {
        parent::__construct($httpMethod);
    }

    /**
     * Method that executes the Business Logic
     * and does all Controlling operations.
     *
     * @note Interaction is similar as a Controller
     *
     * @return void
     */
    public function execute()
    {
        if ($this->checkResource('devices')) {
            InteractionManager::getInstance()->execute('InsertTokenInteraction');
        } elseif ($this->checkToken() !== 1) {
            $this->setMessage('InvalidToken');
        } elseif ($this->checkResource('services')) {
            InteractionManager::getInstance()->execute('InsertServiceInteraction');
        } else {
            $this->getInstruction()->execute();
            $this->setMessage('ResourceItemAdded', ['item_id' => $this->getInstruction()->getInsertId()]);
        }
    }

    /**
     * Method that prepares the Business Logic
     * checking if all checks passes
     *
     * Return if passed or not.
     *
     * @return bool
     */
    public function prepare()
    {
        if (($invalid = RaiseManager::getHandler('request')->checkInvalidParameters()) !== true) {
            $this->setMessage('UnexistentArgument', ['argument' => $invalid]);
        }

        if (($required = $this->checkArguments()) !== true) {
            $this->setMessage('RequiredArgument', ['argument' => $required]);
        }

        return ($required === true && $invalid === true);
    }
}
