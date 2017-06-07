<?php

namespace App\Models\Communication;

/**
 * Class ServiceModel.
 */
class Service extends Raise
{
    /**
     * Service Unique Identifier.
     *
     * @var string
     */
    public $id = '';

    /**
     * Related Client Unique Identifier.
     *
     * @var string
     */
    protected $clientId = '';

    /**
     * Service Name.
     *
     * @required
     *
     * @var string
     */
    public $name;

    /**
     * Parameters of the Service.
     *
     * @required
     *
     * @var array
     */
    public $parameters = [];

    /**
     * Return Type of a Service.
     *
     * @required
     *
     * @var string
     */
    public $returnType = 'string';

    /**
     * ServiceBagModel constructor.
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
     * @param string|null $clientId
     */
    public function setClientId(string $clientId = null)
    {
        global $token;

        $this->clientId = $clientId ?? $token()->clientId;
    }

    /**
     * Get the Related Client Unique Identifier.
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }
}
