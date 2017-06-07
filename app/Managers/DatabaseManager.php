<?php

namespace App\Managers;

use App\Handlers\CouchbaseHandler;
use App\Handlers\SettingsHandler;
use App\Models\Interfaces\Database;

/**
 * Class DatabaseManager.
 */
class DatabaseManager
{
    /**
     * Database Handler Instance.
     *
     * @var Database
     */
    private static $databaseHandler;

    /**
     * Connection Configuration.
     *
     * @var array|object
     */
    private static $configuration;

    /**
     * Get Database Connection.
     *
     * If the Connection doesn't exists, tries to connect.
     *
     * @return CouchbaseHandler|Database
     */
    public static function getHandler()
    {
        if (self::$databaseHandler == null) {
            self::$databaseHandler = self::setHandler();

            self::$databaseHandler->connect(self::$configuration);
        }

        return self::$databaseHandler;
    }

    /**
     * Get Desired DatabaseHandler.
     *
     * @return bool|Database
     */
    protected static function setHandler()
    {
        $handler = SettingsHandler::get('raise.databaseType');

        $className = ('App\Handlers\\' . ucwords($handler) . 'Handler');

        if (class_exists($className)) {
            self::$configuration = SettingsHandler::get('database');

            return new $className();
        }

        return false;
    }
}
