<?php

namespace App\Models\Response;

use App\Models\Communication\Model;

/**
 * Class ResponseModel.
 */
class ResponseModel extends Model
{
    /**
     * Reference HTTP code about response of request.
     *
     * @var string
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
    public $description;
}
