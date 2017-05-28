<?php

namespace App\Models\Settings;

use App\Models\Communication\Model;

/**
 * Class SecuritySettings.
 */
class SecuritySettings extends Model
{
    /**
     * Token Expire Time.
     *
     * @var string
     */
    public $expireTime = '2hours';

    /**
     * RAISe Secret Key
     * That will be used by JWT.
     *
     * @var string
     */
    public $secretKey = 'default-raise-secret-key';
}
