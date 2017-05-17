<?php

namespace App\Factories;

/**
 * Class BaseFactory.
 */
abstract class BaseFactory
{
    /**
     * Elements of the Factory
     *
     * @var array
     */
    protected $elements = [];

    /**
     * Create an Instance if not exists
     * If exists, return the instance
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

    /**
     * Get an Element
     *
     * If the element exists return in,
     * If not return a false boolean.
     *
     * @param String $element
     * @return mixed|bool
     */
    public abstract static function get(String $element);

    /**
     * Add an Element
     *
     * @param String $element
     * @param mixed $content
     * @return mixed
     */
    public abstract static function add(String $element, $content);

    /**
     * Remove an Element
     *
     * Return true if removed with success, false if element doesn't exists
     *
     * @param String $element
     * @return bool
     */
    public abstract static function remove(String $element);
}