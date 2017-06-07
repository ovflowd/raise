<?php

namespace App\Models\Settings;

use App\Handlers\CouchbaseHandler;
use App\Models\Communication\Model;
use App\Models\Interfaces\Database;

/**
 * Class Raise
 *
 * A Setting Model used to describe the current
 * environment of RAISe will operate.
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
     * @see Database
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
