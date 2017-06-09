<?php

/**
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

namespace App\Models\Response;

use App\Models\Communication\Model;
use App\Models\Interfaces\Database as DatabaseHandler;

/**
 * Class Message.
 *
 * A base Model used to output HTTP Messages,
 * the content of it are gathered from the Database
 * and defined by the RFC
 *
 * @property DatabaseHandler
 *
 * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Code Definitions
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Message extends Model
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
     * Additional Details that can be defined
     * and will be sent also on the Response.
     *
     * @var string
     */
    public $details;
}
