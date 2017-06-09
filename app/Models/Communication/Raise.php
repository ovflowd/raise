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

namespace App\Models\Communication;

/**
 * Class Raise.
 *
 * The RAISe Model is a Base Model used as definition of data
 * that will be stored on the Database
 *
 * This Model contains all items that are by default
 * stored on a Document
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
abstract class Raise extends Model
{
    /**
     * The time when the Client requested the operation.
     *
     * @var float (UNIX_TIMESTAMP)
     */
    public $clientTime = 0;
    /**
     * Tags Identifiers.
     *
     * Tags are used to contextual data filtering
     * and may be used to filter set of results
     *
     * @var array
     */
    public $tags = [];
    /**
     * The time when the server handled the operation and inserted it.
     *
     * @var float (UNIX_TIMESTAMP)
     */
    protected $serverTime = 0;

    /**
     * RaiseModel constructor.
     *
     * Set the Timestamps of when RAISe handled
     * this model.
     */
    public function __construct()
    {
        $currentTime = microtime(true);

        $this->setClientTime($currentTime);
        $this->setServerTime($currentTime);
    }

    /**
     * Set manually clientTime
     * with the ability of setting the with the current microtime.
     *
     * @param float|null $clientTime Client Sent Time on UNIX_TIMESTAMP with milliseconds
     */
    public function setClientTime(float $clientTime = null)
    {
        $this->clientTime = $clientTime ?? microtime(true);
    }

    /**
     * Time when the server registered the Data.
     *
     * @return float
     */
    public function getServerTime()
    {
        return $this->serverTime;
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
