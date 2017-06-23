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
 * Class Service.
 *
 * A Service Model is a Schema Definition of
 * A Service and how it will be stored on the Database
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Service extends Raise
{
    /**
     * The Service Name.
     *
     * The Service name uses approaches for contextual Data
     * so we recommend using names that can related
     * of what exactly that service does
     *
     * @required
     *
     * @var string
     */
    public $name;

    /**
     * Parameters of the Service.
     *
     * The parameters are like the header definitions
     * defines what a Data must have when it's registered
     * unto a Service
     *
     * @see Data
     *
     * @required
     *
     * @var array
     */
    public $parameters = [];

    /**
     * Return Type of a Service.
     *
     * This is like what the Service return exactly
     * and the returned data of the headers() definition
     * it's used as an response for a client
     *
     * @required
     *
     * @var string
     */
    public $returnType = 'string';

    /**
     * The Unique Client Identifier.
     *
     * Each Service is related to an Service,
     * this identified which Client the Service is associated
     *
     * @see Client
     *
     * @var string
     */
    protected $clientId = '';

    /**
     * Service constructor.
     *
     * Set the Timestamps of when RAISe handled
     * this model.
     *
     * And set the Client Identifier
     */
    public function __construct()
    {
        parent::__construct();

        $this->setClientId();
    }

    /**
     * Get the Related Client Unique Identifier.
     *
     * @return string Get the Client Identifier
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set the Unique Client Identifier
     * That is related to this Service.
     *
     * @param string|null $clientId the ClientId to be set
     */
    public function setClientId(string $clientId = null)
    {
        global $token;

        $this->clientId = $clientId ?? $token()->clientId;
    }
}
