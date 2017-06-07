<?php

namespace App\Models\Communication;

/**
 * Class Service
 *
 * A Service Model is a Schema Definition of
 * A Service and how it will be stored on the Database
 *
 * @version 2.0.0
 * @since 2.0.0
 */
class Service extends Raise
{
    /**
     * The Unique Identifier of the Service
     * used on the Response
     *
     * @var string
     */
    public $id = '';

    /**
     * The Unique Client Identifier
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
     * The Service Name
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
    public $parameters = array();

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

    /**
     * Get the Related Client Unique Identifier.
     *
     * @return string Get the Client Identifier
     */
    public function getClientId()
    {
        return $this->clientId;
    }
}
