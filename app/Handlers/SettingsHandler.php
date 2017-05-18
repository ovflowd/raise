<?php

namespace App\Handlers;

use App\Factories\SettingsFactory;

/**
 * Class SettingsHandler.
 */
class SettingsHandler
{
    /**
     * Get a Configuration Element from a Settings Model.
     *
     * @param string     $configuration
     * @param null|mixed $settingModel
     * @param null|mixed $value
     *
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

    /**
     * Tries to Add a SettingsModel with given Attributes.
     *
     * Return true if created with success and if class exists, false if it not exists
     *
     * @param string $modelName
     * @param array  $configurationSet
     *
     * @return bool
     */
    public static function add(String $modelName, array $configurationSet)
    {
        if (class_exists($className = 'App\Models\Settings'.ucfirst($modelName).'Settings')) {
            $model = new $className();

            foreach ($configurationSet as $key => $value) {
                if (property_exists($className, $key)) {
                    $model->{$key} = $value;
                }
            }

            SettingsFactory::add($modelName, $model);

            return true;
        }

        return false;
    }

    /**
     * Store all Settings Blocks.
     *
     * @param array $settings
     */
    public static function store(array $settings)
    {
        foreach ($settings as $settingName => $settingModel) {
            self::add($settingName, $settingModel);
        }
    }
}
