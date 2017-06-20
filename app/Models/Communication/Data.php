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

use JsonMapper_Exception;

/**
 * Class Data.
 *
 * A Data Model is a Schema Definition of
 * A Data and how it will be stored on the Database
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Data extends Raise
{
    /**
     * Each Data it's associated to a specific Service.
     *
     * serviceId is the Unique Service Identifier
     * that needs to be stored on the data to link it.
     *
     * @required
     *
     * @var string
     */
    public $serviceId = null;

    /**
     * An array of Data
     * the Data set need follow the key:value pattern
     * You can send anything as data.
     *
     * @required
     *
     * @var array
     */
    public $data = [];

    /**
     * Set a serviceId.
     *
     * This method verifies the validity of the serviceId
     * if it's invalid the method returns a null.
     *
     * @param string $serviceId the service identifier
     *                          related to this data.
     *
     * @throws JsonMapper_Exception
     */
    public function setServiceId(string $serviceId)
    {
        if (database()->selectById('service', $serviceId) === false) {
            throw new JsonMapper_Exception();
        }

        $this->serviceId = $serviceId;
    }
}
