<?php

namespace App\Managers;

use App\Handlers\CouchbaseHandler;
use App\Handlers\SettingsHandler;
use App\Models\Database\DatabaseHandler;

/**
 * Class CouchbaseManager.
 */
class DatabaseManager
{
    /**
     * Database Handler Instance.
     *
     * @var DatabaseHandler
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
     * @return CouchbaseHandler|DatabaseHandler
     */
    public static function getConnection()
    {
        if (self::$databaseHandler == null) {
            self::$databaseHandler = self::getHandler();

            self::$databaseHandler->connect(self::$configuration);
        }

        return self::$databaseHandler;
    }

    /**
     * Get Desired DatabaseHandler.
     *
     * @return bool|DatabaseHandler
     */
    public static function getHandler()
    {
        $handler = SettingsHandler::get('raise.databaseType');

        $className = ('App\Handlers\\'.ucfirst($handler).'Handler');

        if (class_exists($className)) {
            self::$configuration = SettingsHandler::get($handler);

            return new $className();
        }

        return false;
    }
}
