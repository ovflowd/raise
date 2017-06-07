<?php

namespace App\Models\Response;

use App\Models\Communication\Model;

/**
 * Class ServiceRegisterResponse.
 */
class ServiceRegisterResponse extends Model
{
    /**
     * Reference HTTP code about response of request.
     *
     * @var int
     */
    public $codHttp;

    /**
     * Message about HTTP code and/or Couchbase exception code.
     *
     * @var string
     */
    public $message;

    /**
     * The Result values of the Search.
     *
     * @var array
     */
    public $services = [];
}
