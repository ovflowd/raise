<?php

namespace App\Models\Response;

/**
 * Class ResponseModel.
 */
class ResponseModel
{
    /**
     * Reference HTTP code about response of request.
     *
     * @var String
     */
    public $codehttp;

    /**
     * Exception code from Couchbase Database functions.
     *
     * @var String
     */
    public $codecouchbase;

    /**
     * Message about HTTP code and/or Couchbase exception code.
     *
     * @var String
     */
    public $message;

    /**
     * Describes the message and displays the response body.
     *
     * @var String
     */
    public $decription;


}
