<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class NotSqlFilterException
 *
 * @package UIoT\exceptions
 */
final class NotSqlFilterException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('Failed Due Filtering Data', 3);
    }
}