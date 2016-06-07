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
}
