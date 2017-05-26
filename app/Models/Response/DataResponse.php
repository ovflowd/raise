<?php

namespace App\Models\Response;

use App\Models\Communication\Model;

/**
 * Class DataResponse.
 */
class DataResponse extends Model
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
    public $values = [];
}
