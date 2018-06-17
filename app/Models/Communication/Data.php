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

use App\Rules\ClientIdRule;

/**
 * Class Data.
 *
 * A Data Model is a Schema Definition of
 * A Data and how it will be stored on the Database
 *
 * @version 2.1.0
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
     * @rule serviceId
     *
     * @var string
     */
    public $serviceId = null;

    /**
     * A Set of Data.
     *
     * A data set contain an array
     * of data that follows a service parameters pattern
     * an data element need to include values for all
     * the parameters of an service.
     *
     * @required
     *
     * @var array
     */
    public $values = [];

    /**
     * An array that contains the parameters of the
     * Service related to this Data.
     *
     * @rule parameterRule
     *
     * @var string[]
     */
    public $parameters = [];

    /**
     * The Unique Client Identifier.
     *
     * Each Service is related to an Service,
     * this identified which Client the Service is associated
     *
     * @see Client
     *
     * @rule clientId
     *
     * @var string
     */
    protected $clientId = '';

    /**
     * Base RAISe Model Constructor
     *
     * Prepares the Timestamps and other Default Stuff
     */
    public function __construct()
    {
        $this->clientId = ClientIdRule::getClientId();

        parent::__construct();
    }
}
