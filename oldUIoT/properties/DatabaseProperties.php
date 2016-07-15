<?php

namespace UIoT\properties;

/**
 * Class DatabaseProperties
 * @package UIoT\properties
 */
class DatabaseProperties
{
    /**
     * @const DB_HOST Database host.
     */
    private static $dbHost = 'localhost';

    /**
     * @const DB_USER Database user.
     */
    private static $dbUser = 'root';

    /**
     * @const DB_PASS Database pass.
     */
    private static $dbPassword = '';

    /**
     * @const DB_NAME Database name.
     */
    private static $dbName = 'UIOT';

    /**
     * @const DB_TYPE Database type.
     */
    private static $dbType = 'mysql';

    /**
     * @const DB_PORT Database port.
     */
    private static $dbPort = '3306';

    /**
     * Return Database Host
     *
     * @return string
     */
    public static function getHost()
    {
        return self::$dbHost;
    }

    /**
     * Return Database User
     *
     * @return string
     */
    public static function getUser()
    {
        return self::$dbUser;
    }

    /**
     * Return Database Password
     *
     * @return string
     */
    public static function getPassword()
    {
        return self::$dbPassword;
    }

    /**
     * Return Database Name
     *
     * @return string
     */
    public static function getName()
    {
        return self::$dbName;
    }

    /**
     * Return Database Type
     *
     * @return string
     */
    public static function getType()
    {
        return self::$dbType;
    }

    /**
     * Return Database Port
     *
     * @return string
     */
    public static function getPort()
    {
        return self::$dbPort;
    }
}
