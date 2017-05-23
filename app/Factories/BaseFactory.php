<?php

namespace App\Factories;

/**
 * Class BaseFactory.
 */
abstract class BaseFactory
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
     * @param string $element
     *
     * @return mixed|bool
     */
    abstract public static function get(String $element);

    /**
     * Add an Element.
     *
     * @param string $element
     * @param mixed $content
     *
     * @return mixed
     */
    abstract public static function add(String $element, $content);

    /**
     * Remove an Element.
     *
     * Return true if removed with success, false if element doesn't exists
     *
     * @param string $element
     *
     * @return bool
     */
    abstract public static function remove(String $element);

    /**
     * Create an Instance if not exists
     * If exists, return the instance.
     *
     * @return BaseFactory
     */
    protected static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }
}
