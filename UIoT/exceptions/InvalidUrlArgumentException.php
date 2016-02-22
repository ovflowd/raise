<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class InvalidUrlArgumentException
 *
 * @package UIoT/exceptions
 */
final class InvalidUrlArgumentException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('Welcome to RAISE', 200);
    }
}