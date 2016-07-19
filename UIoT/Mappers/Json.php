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

namespace UIoT\Mappers;

use JsonMapper;
use stdClass;

/**
 * Class Json
 *
 * Is a Json Helper for the RAISE environment
 *
 * @package Mappers
 */
final class Json
{
    /**
     * jSON Mapper Instance
     *
     * JsonMapper does the Mapping between jSON
     * Result Sets to Desired Classes
     *
     * @var JsonMapper
     */
    private $jsonMapper;

    /**
     * Create a new Instance of Json if does'nt exists
     *
     * This method does the Singleton Routine Pattern
     * to get the instance of Json class.
     *
     * @return Json
     */
    public static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Encode to jSON an array of objects or an object
     *
     * @param array|object[]|object $modelInstance
     * @return string jSON encoded string
     */
    public function encode($modelInstance)
    {
        return json_encode(is_array($modelInstance) || is_object($modelInstance)
            ? $modelInstance : new stdClass);
    }

    /**
     * Decodes a jSON string to a generic set of
     * standard objects or in an array or in an
     * array of standard objects
     *
     * @param string $jsonString
     * @return array|object|object[]
     */
    public function decode($jsonString)
    {
        return json_decode($jsonString);
    }

    /**
     * Does the Json Mapping through the desired object
     *
     * the jSON content object mainly will be the content returned by the Database
     * and Mapped to respective object
     *
     * @param object|object[] $jsonObject the jSON content
     * @param object $modelInstance instance of desired object to map
     * @return object[]|object instances of the mapped object
     */
    public function convert($jsonObject, $modelInstance)
    {
        return is_array($jsonObject) ?
            $this->getMapper()->mapArray($jsonObject, array(), get_class($modelInstance)) :
            $this->getMapper()->map($jsonObject, new $modelInstance());
    }

    /**
     * Get the JsonMapper Instance
     *
     * The JsonMapper is a library to help
     * jSON messages be converted to desired Models
     *
     * @return JsonMapper
     */
    public function getMapper()
    {
        if (null == $this->jsonMapper) {
            $this->jsonMapper = new JsonMapper;
        }

        return $this->jsonMapper;
    }
}
