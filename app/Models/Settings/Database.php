<?php

namespace App\Models\Settings;

use App\Database\Couchbase as CouchbaseHandler;
use App\Models\Communication\Model;
use App\Models\Interfaces\Database as DatabaseHandler;

/**
 * Class Database.
 *
 * A Setting Model to describe Database settings
 * Supported Databases: {Couchbase}
 *
 * @see https://developer.couchbase.com/documentation/server/current/introduction/intro.html For Couchbase Users
 *
 * @property DatabaseHandler
 * @property CouchbaseHandler
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Database extends Model
{
    /**
     * Database IPv4 Address or Hostname.
     *
     * @uses DatabaseHandler
     * @uses CouchbaseHandler
     *
     * @var string
     */
    public $address = 'localhost';

    /**
     * Database Admin Username.
     *
     * @uses DatabaseHandler
     * @uses CouchbaseHandler
     *
     * @var string
     */
    public $user = 'couch';

    /**
     * Database Admin Password.
     *
     * @uses DatabaseInterface
     * @uses CouchbaseHandler
     *
     * @var string
     */
    public $password = 'couchbase';

    /**
     * Desired Database for RAISe.
     *
     * @uses DatabaseHandler
     *
     * @var string
     */
    public $database = 'my-database';
}
