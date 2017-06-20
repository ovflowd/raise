<?php
/**
 * Created by PhpStorm.
 * User: Faraday
 * Date: 6/9/2017
 * Time: 12:57 PM.
 */

namespace App\Models\Response;

use App\Models\Communication\Model;

class Data extends Model
{
    /**
     * The Applied HTTP Response Code.
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Code Definitions
     *
     * @var int
     */
    public $code;

    /**
     * The HTTP Response Message from the RFC.
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Message Definitions
     *
     * @var string
     */
    public $message;

    /**
     * A set of Clients that will be returned on the Response.
     *
     * @var \App\Models\Communication\Data[]
     */
    public $data = [];
}
