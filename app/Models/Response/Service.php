<?php

namespace App\Models\Response;

use App\Models\Communication\Model;

/**
 * Class Service
 *
 * This is the Response Model of a Service
 * Contains a List of Service of a Service Register set Response
 *
 * @version 2.0.0
 * @since 2.0.0
 */
class Service extends Model
{
    /**
     * The Applied HTTP Response Code
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Code Definitions
     *
     * @var int
     */
    public $codHttp;

    /**
     * The HTTP Response Message from the RFC
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Message Definitions
     *
     * @var string
     */
    public $message;

    /**
     * A set of Services that will be returned on the Response
     *
     * @var Service[]|array
     */
    public $services = array();
}
