<?php

namespace App\Models\Communication;

/**
 * Class Model.
 */
abstract class Model
{
    /**
     * Get all properties from the Model
     *
     * @return object
     */
    public function encode()
    {
        return (object)get_object_vars($this);
    }
}
