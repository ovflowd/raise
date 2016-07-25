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

namespace UIoT\Interfaces;

/**
 * Interface InteractionInterface
 *
 * A Interactions is literally an Interactions that a `client`
 * does in RAISE.
 *
 * @package UIoT\Interfaces
 */
interface InteractionInterface
{
    /**
     * Does the Interactions Business Logic
     * and stores in an internal Variable;
     *
     * Necessary the business logic and logical operations
     * happens in this method.
     *
     * @param string $httpMethod Interaction HTTP Method
     */
    public function __construct($httpMethod);

    /**
     * Used to return the result of the business logic
     * Necessary is a MessageInterface the result.
     * Since the Interactions returns the Message Results
     *
     * @param string $message Message Interface to be Set
     * @param array $templateEngine Template Engine Fields
     * @return void
     */
    public function setMessage($message, array $templateEngine = array());

    /**
     * Used to Return the HTTP Method that the Interaction
     * is related. The Methods can be POST, PUT, GET, DELETE
     *
     * @return string
     */
    public function getMethod();

    /**
     * Set the Response Data Set of an Interaction Process
     *
     * @param array $interactionData
     */
    public function setData(array $interactionData);

    /**
     * Get Interaction Response Data Set
     *
     * @return array
     */
    public function getData();
}
