<?php

namespace App\Models\Communication;

/**
 * Class RaiseModel.
 */
class RaiseModel extends Model
{
    /**
     * Data Tags.
     *
     * @var array
     */
    public $tags = [];

    /**
     * Time when the client sent the Data.
     *
     * @required
     *
     * @var int (UNIX_TIMESTAMP)
     */
    public $clientTime = 0;

    /**
     * Time when the server registered the Data.
     *
     * @var int (UNIX_TIMESTAMP)
     */
    public $serverTime = 0;
}
