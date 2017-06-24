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

/**
 * Class Log.
 *
 * A model to describe a log entry
 *
 * @see Message
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Log extends Model
{
    /**
     * The Unique Identifier of the relative
     * logged entry (service, data, client, token).
     *
     * @var string|null
     */
    public $element = null;

    /**
     * The respective table of the related
     * logged entry (service, data, client, token).
     *
     * @var string|null
     */
    public $table;

    /**
     * The JWT Token used for the Session
     * if it's a request that requires Token auth.
     *
     * @var mixed|null
     */
    public $token = null;

    /**
     * The time when the server handled the operation and inserted it.
     *
     * @var float (UNIX_TIMESTAMP)
     */
    protected $serverTime = 0;

    /**
     * Log constructor.
     *
     * Picks the result content of the result Response
     * and set the serverTime
     *
     * Since every Response actually has a $code and a $message
     */
    public function __construct()
    {
        $this->setServerTime();
    }

    /**
     * Set manually serverTime
     * with the ability of setting the with the current microtime.
     *
     * @param float|null $serverTime Server Time on UNIX_TIMESTAMP with milliseconds
     */
    public function setServerTime(float $serverTime = null)
    {
        $this->serverTime = $serverTime ?? microtime(true);
    }
}
