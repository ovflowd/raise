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

use Symfony\Component\HttpFoundation\Request;
use UIoT\Interfaces\InteractionInterface;
use UIoT\Managers\InstructionManager;
use UIoT\Managers\RaiseManager;
use UIoT\Managers\TokenManager;

/**
 * Class InteractionModel
 * @package UIoT\Models
 */
abstract class InteractionModel implements InteractionInterface
{
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
    public abstract function execute();

    /**
     * Method that prepares the Business Logic
     * checking if all checks passes
     *
     * Return if passed or not.
     *
     * @return bool
     */
    public abstract function prepare();

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
     * @param string $message Message Interface to be Set
     * @param array $templateEngine Template Engine Fields
     * @return void
     */
    public function setMessage($message, array $templateEngine = array())
    {
        RaiseManager::getHandler('response')->setMessage($message, $templateEngine);
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
            TokenManager::getInstance()->setToken($this->getRequest()->query->get('token'));
        }

        return TokenManager::getInstance()->checkToken();
    }

    /**
     * this method checks if the Request's Query String
     * contains all the required Resource Properties (aka arguments)
     * to execute an interaction with it.
     *
     * An optional set of Parameters can be used to complete the Parameters List
     * or to substitute it
     *
     * Return the name of the required property if exists
     * if not return true
     *
     * @param array $optionalArguments
     * @param bool $onlyOptional
     *
     * @return string|bool
     */
    protected function checkArguments(array $optionalArguments = array(), $onlyOptional = false)
    {
        $arguments = $onlyOptional ? $optionalArguments :
            array_keys($this->getResource()->getProperties()->getByOptionality() + array_flip($optionalArguments));

        $optional = array_diff($arguments, array_keys($this->getRequest()->query->all()));

        return !empty($optional) ? implode(';', $optional) : true;
    }

    /**
     * Get the Requested Resource to RAISe
     *
     * @return ResourceModel
     */
    protected function getResource()
    {
        return RaiseManager::getHandler('request')->getResource();
    }

    /**
     * Get the HTTP Request Interface
     *
     * @return Request
     */
    public function getRequest()
    {
        return RaiseManager::getHandler('request')->getRequest();
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
        return $this->getResource()->getFriendlyName() == $expectedResource;
    }

    /**
     * Get the RAISe Instruction Manager
     *
     * @return InstructionManager
     */
    protected function getInstruction()
    {
        return InstructionManager::getInstance();
    }
}
