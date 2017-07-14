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

namespace App\Models\Settings;

use App\Models\Communication\Model;

/**
 * Class Security.
 *
 * A Setting Model that describes Security Interfaces,
 * that are used for Security artifacts.
 *
 * @property Security
 *
 * @version 2.0.0
 *
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
     * the JWT hash is used as Authentication Hash on RAISe.
     *
     * @see https://jwt.io/introduction/ JWT Documentation
     *
     * @var string
     */
    public $secretKey = 'default-raise-secret-key';

    /**
     * The Debug Variable enables full php Logging
     * except with Notices and Warnings.
     * Only PHP Errors. Not recommended for Production.
     *
     * @var bool
     */
    public $debug = false;
}
