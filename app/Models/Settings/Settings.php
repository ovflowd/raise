<?php

namespace App\Models\Settings;

/**
 * Class Settings
 */
abstract class Settings
{
    /**
     * Fill Model Properties
     *
     * @param array $data
     * @return $this
     */
    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }
}