<?php

namespace UIoT\properties;

/**
 * Class DatabaseProperties
 *
 * @package UIoT\properties
 */
class DatabaseProperties
{
    /**
     * @const DB_HOST Database host.
     */
    const DB_HOST = 'localhost';

    /**
     * @const DB_USER Database user.
     */
    const DB_USER = 'root';

    /**
     * @const DB_PASS Database pass.
     */
    const DB_PASS = '';

    /**
     * @const DB_NAME Database name.
     */
    const DB_NAME = 'uiot';

    /**
     * @const DB_TYPE Database type.
     */
    const DB_TYPE = 'mysql';

    /**
     * @const DB_PORT Database port.
     */
    const DB_PORT = '3306';

    /**
     * Returns the DB_HOST constant.
     *
     * @return string
     */
    public static function DB_HOST()
    {
        $db = 'DB_HOST';
        return constant('self::' . $db);
    }

    /**
     * Returns the DB_USER constant.
     *
     * @return string
     */
    public static function DB_USER()
    {
        $db = 'DB_USER';
        return constant('self::' . $db);
    }

    /**
     * Returns the DB_PASS constant.
     *
     * @return string
     */
    public static function DB_PASS()
    {
        $db = 'DB_PASS';
        return constant('self::' . $db);
    }

    /**
     * Returns the DB_NAME constant.
     *
     * @return string
     */
    public static function DB_NAME()
    {
        $db = 'DB_NAME';
        return constant('self::' . $db);
    }

    /**
     * Returns the DB_TYPE constant.
     *
     * @return string
     */
    public static function DB_TYPE()
    {
        $db = 'DB_TYPE';
        return constant('self::' . $db);
    }

    /**
     * Returns the DB_PORT constant.
     *
     * @return int
     */
    public static function DB_PORT()
    {
        $db = 'DB_PORT';
        return constant('self::' . $db);
    }

}

