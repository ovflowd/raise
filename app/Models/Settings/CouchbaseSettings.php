<?php

namespace App\Models\Settings;

use App\Models\Communication\Model;

/**
 * Class CouchbaseSettings.
 */
class CouchbaseSettings extends Model
{
    /**
     * ip address from the couchbase.
     *
     * @var string
     */
    public $address = 'localhost';

    /**
     * user name from the couchbase.
     *
     * @var string
     */
    public $user = 'couchbase';

    /**
     * password from the couchbase.
     *
     * @var string
     */
    public $password = 'couchbase';
}
