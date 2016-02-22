<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class InvalidColumnNameException
 *
 * @package UIoT\exceptions
 */
final class InvalidColumnNameException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('Invalid Requested Column', 6);
    }
}