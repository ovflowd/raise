<?php

namespace App\Models\Response;

use App\Models\Communication\Model;

/**
 * Class Token.
 *
 * This is the Response Model of a Token
 * Contain a Result of Successfully Client Register
 * and Token Generation
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Token extends Model
{
    /**
     * The Applied HTTP Response Code.
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Code Definitions
     *
     * @var int
     */
    public $codHttp;

    /**
     * The HTTP Response Message from the RFC.
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Message Definitions
     *
     * @var string
     */
    public $message;

    /**
     * The generated JWT Hash that will be sent on the Response.
     *
     * @see https://jwt.io/introduction/ JWT Documentation
     *
     * @var string
     */
    public $token;
}
