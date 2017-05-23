<?php

namespace App\Models\Settings;

use App\Models\Communication\Model;

/**
 * Class RaiseSettings.
 */
class RaiseSettings extends Model
{
    /**
     * Type of Database that will be used for connection.
     *
     * @var string
     */
    public $databaseType = 'couchbase';

    /**
     * Base URL of RAISe.
     *
     * @var string
     */
    public $path = '';
}
