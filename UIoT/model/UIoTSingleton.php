<?php

namespace UIoT\model;

/**
 * Class UIoTSingleton
 * @package UIoT\model
 */
class UIoTSingleton
{
    /**
     * @var UIoTSingleton The reference to *Singleton* instance of this class
     */
    protected static $instance;

    /**
     * Protected constructor to prevent creating a new instance of the
     *
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {

    }

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return UIoTSingleton
     */
    public static function getInstance()
    {
        if (null === static::$instance)
            static::$instance = new static();

        return static::$instance;
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {

    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {

    }
}
