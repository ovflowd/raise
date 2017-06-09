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
     * the serviceId it's the Unique Service Identifier
     * that need be stored on the data to link it.
     *
     * @required
     *
     * @var string
     */
    public $serviceId = '';

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
}
