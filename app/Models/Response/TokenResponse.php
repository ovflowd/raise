<?php

namespace App\Models\Response;

use App\Models\Communication\Model;

/**
 * Class TokenResponse.
 */
class TokenResponse extends Model
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
     * The Generated Token
     *
     * @var string
     */
    public $token;
}
