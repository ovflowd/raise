<?php

namespace App\Facades;

/**
 * Class JsonFacade.
 */
class JsonFacade
{
    /**
     * Encode a jSON Object into a string.
     *
     * @param $content
     * @param int $parameters
     *
     * @return string
     */
    public static function encode($content, $parameters = JSON_UNESCAPED_SLASHES)
    {
        return json_encode($content, $parameters);
    }

    /**
     * Decode a jSON string into Object.
     *
     * @param string $content
     *
     * @return mixed
     */
    public static function decode(String $content)
    {
        return json_decode($content);
    }
}
