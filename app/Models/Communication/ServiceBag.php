<?php

namespace App\Models\Communication;

/**
 * Class ServiceBag.
 *
 * A Service Bag Model it's used
 * as a definition for a Service Register Definition
 *
 * The ServiceBag definition isn't used as Service Definition
 * but as outer object Definition, since inside a ServiceBag
 * are stored set of Services
 *
 * @property Service
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class ServiceBag extends Raise
{
    /**
     * A set of Services that will be Registered.
     *
     * @required
     *
     * @var Service[]
     */
    public $services = [];

    /**
     * Stores a set of Services (ServiceModel)
     * inside a Service Bag.
     *
     * @see Service the Service Definition
     *
     * @param Service[] $services
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
