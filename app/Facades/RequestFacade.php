<?php

namespace App\Facades;

/**
 * Class RequestFacade.
 */
class RequestFacade
{
    public abstract static function prepare();

    public abstract static function method();

    public abstract static function body(string $key = null);

    public abstract static function query(string $key = null);
}
