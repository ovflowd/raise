<?php

namespace App\Models\Communication;

/**
 * Class TokenModel.
 */
class Token extends Raise
{
    /**
     * Client Unique Identifier.
     *
     * @required
     *
     * @var string
     */
    public $clientId;

    /**
     * Token Expire Time.
     *
     * @var float
     */
    public $expireTime;

    /**
     * TokenModel constructor.
     *
     * Set the Timestamps of when RAISe handled
     * this model.
     *
     * And set the ExpireTime
     */
    public function __construct()
    {
        parent::__construct();

        $this->setExpireTime();
    }

    /**
     * Set the Token Expire Time.
     *
     * @return $this
     */
    public function setExpireTime()
    {
        $this->expireTime = strtotime('+'.setting('security.expireTime'), $this->serverTime);

        return $this;
    }
}
