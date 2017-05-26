<?php

namespace App\Models\Response;

use App\Models\Communication\Model;

/**
 * Class MessageResponse.
 */
class MessageResponse extends Model
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
     * Describes the message and displays the response body.
     *
     * @var string
     */
    public $details;
}
