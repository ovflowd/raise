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

use UIoT\Managers\TokenManager;
use UIoT\Models\InteractionModel;

/**
 * Class UpdateTokenInteraction
 * @package UIoT\Interactions
 */
class UpdateTokenInteraction extends InteractionModel
{
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
        if ($this->checkToken() === 1) {
            $this->setMessage('TokenStillValid');
        } elseif ($this->prepare()) {
            TokenManager::getInstance()->updateToken();
            $this->setMessage('TokenUpdated', ['token' => TokenManager::getInstance()->getToken()->getHash()]);
        } else {
            $this->setMessage('InvalidValue');
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
        if (($required = $this->checkArguments()) !== true) {
            $this->setMessage('RequiredArgument', ['argument' => $required]);
        }

        return $required === true;
    }
}