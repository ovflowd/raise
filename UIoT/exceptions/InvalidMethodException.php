<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class InvalidMethodException
 *
 * @package UIoT\exceptions
 */
final class InvalidMethodException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('Invalid REST Method', 500);
    }
}