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
     * @param int $exit_code
     */
    public static function showJson($value = NULL, $exit_code = 0)
    {
        if (null === $value || empty($value))
            $value = new stdClass();

        echo json_encode($value, JSON_PRETTY_PRINT);

        exit($exit_code);
    }
}
