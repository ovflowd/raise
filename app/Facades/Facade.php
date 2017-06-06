<?php

namespace App\Facades;

/**
 * Class Facade
 */
abstract class Facade
{
    /**
     * Get the Facade Instance.
     *
     * @return Facade|string
     */
    public static function get()
    {
        return static::class;
    }
}