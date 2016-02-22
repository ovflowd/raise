<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class InvalidRaiseResourceException
 *
 * @package UIoT/exceptions
 */
final class InvalidRaiseResourceException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('Invalid Resource Requested to Raise', 404);
    }
}