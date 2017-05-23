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
     * @var string
     */
    public $httpCode;

    /**
     * Exception code from Couchbase Database functions.
     *
     * @var string
     */
    public $couchbaseCode;

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
