<?php

namespace UIoT\exceptions;

use UIoT\interfaces\RaiseException;

/**
 * Class DatabaseConnectionFailedException
 *
 * @package UIoT\exceptions
 */
final class DatabaseConnectionFailedException extends RaiseException
{
    public function __construct()
    {
        parent::__construct('RAISE can\'t Connect on UIoT Data Server', 8);
    }
}