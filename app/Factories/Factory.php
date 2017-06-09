<?php

/**
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

namespace App\Factories;

/**
 * Class Factory.
 *
 * A Design Pattern used to manage
 * and manipulate data set.
 *
 * @see https://en.wikipedia.org/wiki/Factory_method_pattern About the Pattern
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
abstract class Factory
{
    /**
     * Elements of the Factory.
     *
     * @var array
     */
    protected $elements = [];

    /**
     * Get an Element.
     *
     * If the element exists return in,
     * If not return a false boolean.
     *
     * @param string $element name of the element
     *
     * @return object|array|bool the element or false if didn't found it
     */
    abstract public static function get(string $element);

    /**
     * Add an Element.
     *
     * @param string       $element the name of the element to be added
     * @param array|object $content the content of the element
     *
     * @return bool if added successfully or not
     */
    abstract public static function add(string $element, $content);

    /**
     * Remove an Element.
     *
     * Return true if removed with success, false if element doesn't exists
     *
     * @param string $element the element to be removed
     *
     * @return bool if removed successfully or not
     */
    abstract public static function remove(string $element);

    /**
     * Create an Instance if not exists
     * If exists, return the instance.
     *
     * @return Factory
     */
    protected static function instance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }
}
