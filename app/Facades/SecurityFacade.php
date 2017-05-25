<?php

namespace App\Facades;

use App\Models\Communication\RaiseModel;
use stdClass;

/**
 * Class SecurityFacade.
 */
class SecurityFacade
{
    /**
     * Generate a random pseudo string that will be used as token
     * the token will be always of 40 characters.
     *
     * @return string
     */
    public static function generateToken()
    {
        return openssl_random_pseudo_bytes(40);
    }

    abstract public static function validateToken(string $httpMethod, string $token);

    abstract public static function validateParams(string $httpMethod, stdClass $body, RaiseModel $model);
}
