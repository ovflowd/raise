<?php

namespace App\Models\Communication;

/**
 * Class TokenModel.
 */
class TokenModel extends RaiseModel
{
    /**
     * Client Unique Identifier.
     *
     * @required
     *
     * @var int
     */
    public $clientId;

    /**
     * Token Expire Time.
     *
     * @var int
     */
    public $expireTime;

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
