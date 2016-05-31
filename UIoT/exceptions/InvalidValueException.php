<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class InvalidValueException
 *
 * @package UIoT\exceptions
 */
final class InvalidValueException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('Data has Invalid Value', 5);
    }
}