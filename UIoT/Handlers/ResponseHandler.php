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

namespace UIoT\Handlers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UIoT\Managers\RaiseManager;
use UIoT\Models\InteractionModel;

/**
 * Class ResponseHandler
 * @package UIoT\Handlers
 */
class ResponseHandler
{
    /**
     * HTTP Response Interface
     *
     * @var JsonResponse
     */
    private $httpResponse;

    /**
     * Instantiate Symfony HTTP Foundation's JsonResponse
     * using Symfony's HTTP Foundation Request
     *
     * The Response Interface is used to populate RAISe Response
     */
    public function __construct()
    {
        $this->httpResponse = new JsonResponse;
        $this->httpResponse->prepare(Request::createFromGlobals());
        $this->httpResponse->setEncodingOptions(JSON_PRETTY_PRINT);
    }

    /**
     * Executes an Interaction and gathering
     * its results in the HTTP Response Interface
     * as jSON Object or jSON Data Set
     *
     * @param InteractionModel $interaction
     */
    public function executeInteraction(InteractionModel $interaction)
    {
        /* By default Message is Invalid Token */
        $this->setMessage('InvalidToken');

        /* Executes the Interaction process */
        if ($interaction->prepare()) {
            $interaction->execute();
        }

        if ($interaction->getData() !== null) {
            $this->setData($interaction->getData());
        }
    }

    /**
     * Used to set the HTTP Response Content
     * as an jSON Data Set (array)
     *
     * @param array $raiseData
     */
    public function setData(array $raiseData)
    {
        $this->getResponse()->setData($raiseData);
    }

    /**
     * Return the HTTP Response Interface
     *
     * @return JsonResponse
     */
    public function getResponse()
    {
        return $this->httpResponse;
    }

    /**
     * Used to set the HTTP Response Content
     * as an RAISe Message (object)
     *
     * @param string $message Message Name
     * @param array $templateEngine
     */
    public function setMessage($message, array $templateEngine = array())
    {
        $this->getResponse()->setData(RaiseManager::getFactory('message')->get($message,
            $templateEngine)->__getResult());
    }

    /**
     * Get the HTTP Response Interface Result
     * by Applying the HTTP Headers
     * and retrieving the jSON encoded content
     *
     * @return string
     */
    public function sendResponse()
    {
        /* Set HTTP Headers from HTTP Response Interface */
        $this->getResponse()->sendHeaders();

        /* Get HTTP Response Interface Content */
        return $this->getResponse()->getContent();
    }
}
