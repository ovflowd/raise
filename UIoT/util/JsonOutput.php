<?php

namespace UIoT\util;

use stdClass;

/**
 * Class JsonOutput
 * @package UIoT\util
 */
final class JsonOutput
{
    /**
     * Show jSON
     *
     * @param null|string|mixed|object|array $value
     * @return string
     */
    public static function showJson($value = null)
    {
        if (null === $value || empty($value))
            $value = new stdClass();

        return json_encode($value, JSON_PRETTY_PRINT);
    }
}
