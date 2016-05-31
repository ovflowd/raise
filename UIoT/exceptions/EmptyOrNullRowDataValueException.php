<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class EmptyOrNullRowDataValueException
 *
 * @package UIoT/exceptions
 */
final class EmptyOrNullRowDataValueException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('Data Server Returned Exception on Gathering Data', 7);
    }
}