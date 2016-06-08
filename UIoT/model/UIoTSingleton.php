<?php

namespace UIoT\model;

/**
 * Class UIoTSingleton
 * @package UIoT\model
 */
class UIoTSingleton
{
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
        static $instance = null;

        if (null === $instance)
            $instance = new static();

        return $instance;
    }
}
