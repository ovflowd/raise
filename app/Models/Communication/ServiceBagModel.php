<?php

namespace App\Models\Communication;

/**
 * Class ServiceBagModel.
 */
class ServiceBagModel
{
    /**
     * Service Name
     *
     * @var string
     */
    public $name;

    /**
     * Parameters of the Service
     *
     * @var ServiceBagModel[]
     */
    public $parameters = [];

    /**
     * Return Type of a Service
     *
     * @var string
     */
    public $returnType = 'string';
}
