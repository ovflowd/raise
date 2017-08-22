<?php

/**
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

namespace App\Models\Settings;

use App\Database\Couchbase as CouchbaseHandler;
use App\Models\Communication\Model;
use App\Models\Interfaces\Database as DatabaseHandler;

/**
 * Class Raise.
 *
 * A Setting Model used to describe the current
 * environment of RAISe will operate.
 *
 * @property DatabaseHandler
 * @property CouchbaseHandler
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Raise extends Model
{
    /**
     * The desired DatabaseHandler that will be used
     *  as Handler for current RAISe environment.
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
     * on the DocumentRoot.
     *
     * @var string
     */
    public $path = '';

    /**
     * The time zone that PHP will run and store the data.
     *
     * @see http://php.net/manual/pt_BR/function.date-default-timezone-set.php
     * @see https://www.ietf.org/rfc/rfc2822.txt
     *
     * @var string
     */
    public $timeZone = 'America/Sao_Paulo';
}
