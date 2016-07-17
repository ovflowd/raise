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

namespace UIoT\Interfaces;

/**
 * Interface MessageInterface
 *
 * A RAISE Message is the result of an operation is RAISE
 * and is a jSON Message returned from RAISE to the `client`
 *
 * @package UIoT\Interfaces
 */
interface MessageInterface
{
    /**
     * Return the Message Identifier
     *
     * The RAISE message identifier is a string that
     * identifies the category of the RAISe message
     *
     * @return string
     */
    public function getId();

    /**
     * Returns the Message Code
     *
     * The Message codes ARE'NT UNIQUE.
     * Multiple messages can have the same code.
     *
     * Necessary every Message needs a Code.
     * The message code identifies the Message, like a HTTP Code
     *
     * Always a number from 0 to 999.
     *
     * @return int
     */
    public function getCode();

    /**
     * Returns the Main Message String
     *
     * Necessary every Message needs a main string message
     * specifying what the message does or what happened.
     *
     * Is like a message description.
     *
     * Always a string
     *
     * @return string
     */
    public function getMessage();

    /**
     * Returns a Dynamic Property from a RAISE Message.
     *
     * RAISE Message Properties are populated in a dynamic way
     * from the Database `MESSAGES` table. The messages have
     * <KeyValuePair> (VariableName : VariableValue)
     *
     * The return type necessary is a string.
     *
     * @param string $propertyName
     * @return string
     */
    public function __get($propertyName);

    /**
     * Set a Dynamic Property from a RAISE Message.
     *
     * RAISE Message Properties are populated in a dynamic way
     * from the Database `MESSAGES` table. The messages have
     * <KeyValuePair> (VariableName : VariableValue)
     *
     * @param string $propertyName
     * @param string $propertyValue
     * @return void
     */
    public function __set($propertyName, $propertyValue);

    /**
     * Returns jSON Encoded of the Message
     *
     * The `JsonEncoder` class does the Encoding from the Object
     * to a jSON
     *
     * @return string
     */
    public function __toString();
}
