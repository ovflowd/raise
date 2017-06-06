<?php

namespace App\Models\Communication;

/**
 * Class DataModel.
 */
class DataModel extends RaiseModel
{
    /**
     * Service Identifier for the Data Bag.
     *
     * @required
     *
     * @var string
     */
    public $serviceId = '';

    /**
     * Array of Data.
     *
     * @required
     *
     * @var array
     */
    public $data = array();

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
