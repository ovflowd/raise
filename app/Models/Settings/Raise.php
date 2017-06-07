<?php

namespace App\Models\Settings;

use App\Database\Couchbase as CouchbaseHandler;
use App\Models\Communication\Model;
use App\Models\Interfaces\Database as DatabaseHandler;

/**
 * Class Raise
 *
 * A Setting Model used to describe the current
 * environment of RAISe will operate.
 *
 * @property DatabaseHandler
 * @property CouchbaseHandler
 *
 * @version 2.0.0
 * @since 2.0.0
 */
class Raise extends Model
{
    /**
     * The desired DatabaseHandler that will be used
     *  as Handler for current RAISe environment
     *
     * @see DatabaseHandler
     * @see CouchbaseHandler
     *
     * @var string
     */
    public $databaseType = 'couchbase';

    /**
     * The base path of RAISe, like SCHEMA://URL/BASE-PATH,
     * by default is empty that means that RAISe it's running
     * on the DocumentRoot
     *
     * @var string
     */
    public $path = '';
}
