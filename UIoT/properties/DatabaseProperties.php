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
    const DB_HOST = '172.16.6.164';

    /**
     * @const DB_USER Database user.
     */
    const DB_USER = 'root';

    /**
     * @const DB_PASS Database pass.
     */
    const DB_PASS = 'ac41tr1421';

    /**
     * @const DB_NAME Database name.
     */
    const DB_NAME = 'UIOT';

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
        return constant('self::' . 'DB_HOST');
    }

    /**
     * Returns the DB_USER constant.
     *
     * @return string
     */
    public static function DB_USER()
    {
        return constant('self::' . 'DB_USER');
    }

    /**
     * Returns the DB_PASS constant.
     *
     * @return string
     */
    public static function DB_PASS()
    {
        return constant('self::' . 'DB_PASS');
    }

    /**
     * Returns the DB_NAME constant.
     *
     * @return string
     */
    public static function DB_NAME()
    {
        return constant('self::' . 'DB_NAME');
    }

    /**
     * Returns the DB_TYPE constant.
     *
     * @return string
     */
    public static function DB_TYPE()
    {
        return constant('self::' . 'DB_TYPE');
    }

    /**
     * Returns the DB_PORT constant.
     *
     * @return int
     */
    public static function DB_PORT()
    {
        return constant('self::' . 'DB_PORT');
    }

}

