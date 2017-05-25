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
     */
    public function setExpireTime()
    {
        $this->expireTime = strtotime('+'.SettingsHandler::get('security.expireTime'), $this->serverTime);
    }
}
