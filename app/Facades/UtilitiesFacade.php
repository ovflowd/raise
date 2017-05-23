<?php

namespace App\Facades;

/**
 * Class UtilitiesFacade.
 */
class UtilitiesFacade
{
    public abstract function inArray(array $search, array $needle);

    public abstract function arrayDiff(array $original, array $compareTo);
}
