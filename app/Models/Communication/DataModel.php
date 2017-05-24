<?php

namespace App\Models\Communication;

/**
 * Class DataModel.
 */
class DataModel extends RaiseModel
{
    /**
     * Array of Data.
     *
     * @var array
     */
    public $data = [];

    /**
     * Service Identifier for the Data Bag
     *
     * @var int
     */
    public $serviceId;

    /**
     * Add a Data Bag.
     *
     * DataBag: key:value
     *
     * @param string $key
     * @param string $value
     */
    public function addBag(string $key, string $value)
    {
        $this->data[] = array($key, $value);
    }
}
