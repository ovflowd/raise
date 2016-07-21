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

use UIoT\Interfaces\MessageInterface;

/**
 * Class MessageModel
 * @package UIoT\Models
 */
final class MessageModel implements MessageInterface
{
    /**
     * RAISe Message Identifier
     *
     * @var string
     */
    public $ID;

    /**
     * RAISE Message Code
     *
     * @var int
     */
    public $code;

    /**
     * RAISE Message Description
     *
     * @var string
     */
    public $message;

    /**
     * Return the Message Identifier
     *
     * The RAISE message identifier is a string that
     * identifies the category of the RAISe message
     *
     * @return string
     */
    public function getId()
    {
        return $this->ID;
    }

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
    public function getCode()
    {
        return $this->code;
    }

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
    public function getMessage()
    {
        return $this->message;
    }

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
    public function __get($propertyName)
    {
        return $this->{$propertyName};
    }

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
    public function __set($propertyName, $propertyValue)
    {
        $this->{$propertyName} = $propertyValue;
    }

    /**
     * Return the MessageInterface Public Values
     *
     * @return object
     */
    public function __getResult()
    {
        return (object)array_diff_key((array)$this, ['ID' => '']);
    }
}
