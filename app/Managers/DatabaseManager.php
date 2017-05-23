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
     * Database Handler Instance
     *
     * @var DatabaseHandler
     */
    private static $databaseHandler;

    /**
     * Get Database Connection
     *
     * If the Connection doesn't exists, tries to connect.
     *
     * @return CouchbaseHandler|DatabaseHandler
     */
    public static function getConnection()
    {
        if (self::$databaseHandler == null) {
            self::$databaseHandler = new CouchbaseHandler();

            self::$databaseHandler->connect((array)SettingsHandler::get('couchbase'));
        }

        return self::$databaseHandler;
    }
}
