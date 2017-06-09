<?php

/**
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

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
