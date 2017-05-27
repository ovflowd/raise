<?php

namespace App\Models\Communication;

use App\Handlers\SettingsHandler;

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
     * Client Token.
     *
     * @see http://php.net/manual/pt_BR/function.openssl-random-pseudo-bytes.php
     * @required
     *
     * @var string
     */
    public $tokenId;

    /**
     * Set the Token Expire Time.
     *
     * @return $this
     */
    public function setExpireTime()
    {
        $this->expireTime = strtotime('+'.SettingsHandler::get('security.expireTime'), $this->serverTime);

        return $this;
    }
}
