<?php

namespace App\Models\Communication;

/**
 * Class DataModel
 */
class DataModel extends RaiseModel
{
    /**
     * Array of Datas
     *
     * @var DataBagModel[]
     */
    public $data = [];

    /**
     * Add a Data Bag
     *
     * @param DataBagModel $bag
     */
    public function addBag(DataBagModel $bag)
    {
        $this->data[] = $bag;
    }
}