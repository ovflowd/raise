<?php

namespace App\Handlers;

use App\Factories\SettingsFactory;

/**
 * Class SettingsHandler.
 */
class SettingsHandler
{
    /**
     * Get a Configuration Element from a Settings Model
     *
     * @param String $configuration
     * @param null|mixed $settingModel
     * @param null|mixed $value
     * @return bool|mixed
     */
    public static function get(String $configuration, $settingModel = null, $value = null)
    {
        if (strpos($configuration, '.') !== false) {
            if ($settingModel == null) {
                return self::get(strstr($configuration, '.', true),
                    SettingsFactory::get(explode('.', $configuration)[0]));
            }

            return self::get(strstr($configuration, '.', true), $settingModel,
                $settingModel->{explode('.', $configuration)[0]});
        } elseif ($settingModel !== null && $value !== null) {
            return $value->{$configuration};
        } else {
            return SettingsFactory::get($configuration);
        }
    }
}
