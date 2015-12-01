<?php

namespace UIoT\properties;

/**
 * Class DatabaseProperties
 * contains database information
 * @package UIoT\properties
 */

class DatabaseProperties
{
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_NAME = 'uiot';
    const DB_TYPE = 'mysql';
    const DB_PORT = '3306';

    public static function DB_HOST()
    {
        $db = 'DB_HOST';
        return constant('self::' . $db);
    }

    public static function DB_USER()
    {
        $db = 'DB_USER';
        return constant('self::' . $db);
    }

    public static function DB_PASS()
    {
        $db = 'DB_PASS';
        return constant('self::' . $db);
    }

    public static function DB_NAME()
    {
        $db = 'DB_NAME';
        return constant('self::' . $db);
    }

    public static function DB_TYPE()
    {
        $db = 'DB_TYPE';
        return constant('self::' . $db);
    }

    public static function DB_PORT()
    {
        $db = 'DB_PORT';
        return constant('self::' . $db);
    }

}
