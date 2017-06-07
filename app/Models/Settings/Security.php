<?php

namespace App\Models\Settings;

use App\Facades\SecurityFacade;
use App\Models\Communication\Model;

/**
 * Class Security
 *
 * A Setting Model that describes Security Interfaces,
 * that are used for Security artifacts.
 *
 * @property SecurityFacade
 *
 * @version 2.0.0
 * @since 2.0.0
 */
class Security extends Model
{
    /**
     * The Authorization Token expire time,
     * this property uses the php's strtotime()
     * method to describe how many time will be added
     * until the token expires summed with the current time.
     *
     * @see http://php.net/manual/en/function.strtotime.php strtotime() documentation
     *
     * @var string
     */
    public $expireTime = '2hours';

    /**
     * The Secret Key that will be used on the JWT hash,
     * the JWT hash is used as Authentication Hash on RAISe
     *
     * @see https://jwt.io/introduction/ JWT Documentation
     *
     * @var string
     */
    public $secretKey = 'default-raise-secret-key';
}
