<?php

namespace App\Facades;

/**
 * Class JsonFacade.
 */
class JsonFacade
{
    public abstract function encode($content, array $parameters = array());

    public abstract function decode(String $content);
}
