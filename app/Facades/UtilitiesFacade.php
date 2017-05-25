<?php

namespace App\Facades;

/**
 * Class UtilitiesFacade.
 */
class UtilitiesFacade
{
    /**
     * Compares two arrays and returns their difference
     *
     * @param array $original
     * @param array $compareTo
     * @return array
     */
    public static function arrayDiff(array $original, array $compareTo)
    {
        return array_diff(array_keys($original), array_keys($compareTo));
    }

    public function inArray(array $search, array $needle)
    {
        return false;
    }
}
