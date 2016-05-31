<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class NotArrayException
 *
 * @package UIoT\exceptions
 */
final class NotArrayException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('Failed Parsering Incoming Data', 4);
    }
}