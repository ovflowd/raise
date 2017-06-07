<?php

namespace App\Models\Communication;

/**
 * Class ServiceBagModel.
 */
class ServiceBagModel extends RaiseModel
{
    /**
     * Array of Service Models.
     *
     * @required
     *
     * @var ServiceModel[]
     */
    public $services = array();

    /**
     * Add a Service Bag into a Service Model.
     *
     * @param ServiceModel[] $services
     */
    public function setServices(array $services)
    {
        array_walk($services, function ($service) {
            $service->clientTime = $this->clientTime;
            $service->tags = $this->tags;
        });

        $this->services = $services;
    }
}
