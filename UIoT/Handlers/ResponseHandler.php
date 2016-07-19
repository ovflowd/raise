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

namespace UIoT\Handlers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UIoT\Interfaces\MessageInterface;
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
        $this->httpResponse = new JsonResponse();
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
        /* executes the Interaction process */
        $interaction->executeProcess();

        if ($interaction->getMessage() !== null) {
            $this->setMessage($interaction->getMessage());
        } elseif ($interaction->getData() !== null) {
            $this->setData($interaction->getData());
        }
    }

    /**
     * Used to set the HTTP Response Content
     * as an RAISe Message (object)
     *
     * @param MessageInterface $message
     */
    public function setMessage(MessageInterface $message)
    {
        $this->getResponse()->setData($message->__getResult());
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
     * as an jSON Data Set (array)
     *
     * @param array $raiseData
     */
    public function setData(array $raiseData)
    {
        $this->getResponse()->setData($raiseData);
    }
}
