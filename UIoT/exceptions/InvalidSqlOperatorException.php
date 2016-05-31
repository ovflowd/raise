<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class InvalidSqlOperatorException
 *
 * @package UIoT\exceptions
 */
final class InvalidSqlOperatorException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('Invalid Operator on Database', 200);
    }
}