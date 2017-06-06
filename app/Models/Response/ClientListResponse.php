<?php

namespace App\Models\Response;

use App\Models\Communication\Model;

/**
 * Class ClientListResponse.
 */
class ClientListResponse extends Model
{
    /**
     * Reference HTTP code about response of request.
     *
     * @var int
     */
    public $codHttp;

    /**
     * The Result values of the Search.
     *
     * @var array
     */
    public $clients = array();
}
