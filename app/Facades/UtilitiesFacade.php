<?php

namespace App\Facades;

/**
 * Class UtilitiesFacade.
 */
class UtilitiesFacade
{
    abstract public function inArray(array $search, array $needle);

    abstract public function arrayDiff(array $original, array $compareTo);
}
