<?php

namespace App\Models\Communication;

/**
 * Class ServiceModel.
 */
class ServiceModel extends RaiseModel
{
    /**
     * Array of Service Models.
     *
     * @required
     *
     * @var ServiceBagModel[]
     */
    public $services = array();

    /**
     * Add a Service Bag into a Service Model.
     *
     * @param ServiceBagModel $bag
     */
    public function addBag(ServiceBagModel $bag)
    {
        $this->services[] = $bag;
    }
}
