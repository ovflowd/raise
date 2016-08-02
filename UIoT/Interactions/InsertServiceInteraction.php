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

use UIoT\Managers\DatabaseManager;
use UIoT\Mappers\Constants;
use UIoT\Models\InteractionModel;

/**
 * Class InsertServiceInteraction
 * @package UIoT\Interactions
 */
class InsertServiceInteraction extends InteractionModel
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
        DatabaseManager::getInstance()->query(Constants::getInstance()->get('addServiceAction'), [
            ':ACT_NAME' => $this->getRequest()->query->get('name'),
            ':ACT_TYPE' => $this->getRequest()->query->get('type')
        ]);

        $this->setMessage('ServiceInsertion',
            ['action_id' => $actionId = DatabaseManager::getInstance()->getLastInsertId()]);

        DatabaseManager::getInstance()->query(Constants::getInstance()->get('addServiceActionRelation'),
            [':SRVC_ID' => $this->getInstruction()->getInsertId(), ':ACT_ID' => $actionId]);
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
        $this->getInstruction()->execute();

        return true;
    }
}