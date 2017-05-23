<?php

namespace App\Facades;

use App\Models\Communication\RaiseModel;
use stdClass;

/**
 * Class SecurityFacade.
 */
class SecurityFacade
{
    abstract public static function generateToken();

    abstract public static function validateToken(string $httpMethod, string $token);

    abstract public static function validateParams(string $httpMethod, stdClass $body, RaiseModel $model);
}
