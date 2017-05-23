<?php

namespace App\Facades;

/**
 * Class RequestFacade.
 */
class RequestFacade
{
    abstract public static function prepare();

    abstract public static function method();

    abstract public static function body(string $key = null);

    abstract public static function query(string $key = null);
}
