<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class RowDataValueNotSupportedException
 *
 * @package UIoT\exceptions
 */
final class RowDataValueNotSupportedException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('Invalid Request Data', 2);
    }
}