<?php

namespace App\Models\Communication;

/**
 * Class Model
 */
abstract class Model
{
    /**
     * Fill Model Properties
     *
     * @param array|object $data
     * @return $this
     */
    public function fill($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }
}