<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class CriteriaNotSupportedException
 *
 * @package UIoT/exceptions
 */
final class CriteriaNotSupportedException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('Invalid Operation at Data Manipulation', 9);
    }
}