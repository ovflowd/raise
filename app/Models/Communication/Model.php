<?php

namespace App\Models\Communication;

/**
 * Class Model.
 *
 * This is the base class using
 * the Definition of MVC Models
 *
 * A Model stores Data and manipulate it.
 *
 * @see https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller MVC Pattern
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
abstract class Model
{
    /**
     * Get all public properties of the Model
     * It's used for the Response Mapping on Lists.
     *
     * @return array the public properties of a Model
     */
    public function encode()
    {
        return get_object_vars($this);
    }
}
