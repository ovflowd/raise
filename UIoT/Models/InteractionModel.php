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

use UIoT\Interfaces\InteractionInterface;
use UIoT\Interfaces\MessageInterface;
use UIoT\Managers\RaiseManager;
use UIoT\Managers\TokenManager;

/**
 * Class InteractionModel
 * @package UIoT\Models
 */
abstract class InteractionModel implements InteractionInterface
{
    /**
     * The Message Result of the Interaction Process
     * @note the Message can be null if the Response is a set of Data
     *
     * @var MessageInterface
     */
    protected $interactionMessage;

    /**
     * The Content Data of the Interaction Process
     * @note the Data can be empty if the Response isn't a Data Set
     * @note necessary if isn't empty need be an array of Data
     *
     * @var array
     */
    protected $interactionData;

    /**
     * The HTTP Method related to the Interaction
     *
     * @var string
     */
    protected $interactionMethod;

    /**
     * Reset's the internal Message variable
     * and set the HTTP Method desired for the
     * correspondent Interaction
     *
     * @param string $httpMethod Interaction HTTP Method
     */
    public function __construct($httpMethod)
    {
        $this->interactionMethod = $httpMethod;
        $this->interactionMessage = null;
    }

    /**
     * Used to return the result of the business logic
     * Necessary is a MessageInterface the result.
     * Since the Interactions returns the Message Results
     *
     * @return MessageInterface
     */
    public function getMessage()
    {
        return $this->interactionMessage;
    }

    /**
     * Get Interaction Response Data Set
     *
     * @return array
     */
    public function getData()
    {
        return $this->interactionData;
    }

    /**
     * Set the Response Data Set of an Interaction Process
     *
     * @param array $interactionData
     */
    public function setData(array $interactionData)
    {
        $this->interactionData = $interactionData;
    }

    /**
     * Method that executes the Business Logic
     * and does all Controlling operations.
     *
     * @note Interaction is similar as a Controller
     *
     * @return void
     */
    public abstract function executeProcess();

    /**
     * Used to Return the HTTP Method that the Interaction
     * is related. The Methods can be POST, PUT, GET, DELETE
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->interactionMethod;
    }

    /**
     * Used to return the result of the business logic
     * Necessary is a MessageInterface the result.
     * Since the Interactions returns the Message Results
     *
     * @param string $messageInterface Message Interface to be Set
     * @param array $templateEngine Template Engine Fields
     * @return void
     */
    public function setMessage($messageInterface, array $templateEngine = array())
    {
        $this->interactionMessage = RaiseManager::getInstance()->getFactory('messageFactory')->get($messageInterface,
            $templateEngine);
    }

    /**
     * Check if the Token given by the `client` is valid or not.
     * If the `client` does'nt sent a token in query string also
     * the validation will return 0 (zero).
     *
     * If the Token isn't anymore valid (expired) will return -1
     * If is valid will return 1 (one)
     *
     * @return int (-1 : Expired, 0 : Invalid, 1 : Valid)
     */
    protected function checkToken()
    {
        if (TokenManager::getInstance()->getToken() === null) {
            TokenManager::getInstance()->setToken(RaiseManager::getInstance()
                ->getHandler('requestHandler')->getRequest()->query->get('token'));
        }

        return TokenManager::getInstance()->checkToken();
    }

    /**
     * This method checks if the Resource given in the HTTP Request
     * is the same of the Resource given in the method argument.
     *
     * @note this is useful for Specific Interactions that works
     * with specific Resources and Methods
     *
     * @param string $expectedResource
     * @return bool If Resource is the expected Resource
     */
    protected function checkResource($expectedResource = '')
    {
        return RaiseManager::getInstance()->getHandler('requestHandler')->getResource() == $expectedResource;
    }
}
