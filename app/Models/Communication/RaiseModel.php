<?php

namespace App\Models\Communication;

/**
 * Class RaiseModel.
 */
class RaiseModel extends Model
{
    /**
     * Data Tags.
     *
     * @var array
     */
    public $tags = [];

    /**
     * Time when the client sent the Data.
     *
     * @var float (UNIX_TIMESTAMP)
     */
    public $clientTime = 0;

    /**
     * Time when the server registered the Data.
     *
     * @var float (UNIX_TIMESTAMP)
     */
    public $serverTime = 0;

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
     * with the ability of setting the with the current microtime
     *
     * @param float|null $clientTime Client Sent Time on UNIX_TIMESTAMP with milliseconds
     */
    public function setClientTime(float $clientTime = null)
    {
        $this->clientTime = $clientTime ?? microtime(true);
    }

    /**
     * Set manually serverTime
     * with the ability of setting the with the current microtime
     *
     * @param float|null $serverTime Server Time on UNIX_TIMESTAMP with milliseconds
     */
    public function setServerTime(float $serverTime = null)
    {
        $this->serverTime = $serverTime ?? microtime(true);
    }
}
