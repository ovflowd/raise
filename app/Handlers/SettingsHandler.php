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
     * @param string $configuration
     *
     * @return bool|mixed
     */
    public static function get(String $configuration)
    {
        if (strpos($configuration, '.') !== false) {
            $values = explode('.', $configuration);

            return SettingsFactory::get($values[0])->{$values[1]};
        } else {
            return SettingsFactory::get($configuration);
        }
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

    /**
     * Tries to Add a SettingsModel with given Attributes.
     *
     * Return true if created with success and if class exists, false if it not exists
     *
     * @param string $modelName
     * @param array $configurationSet
     *
     * @return bool
     */
    public static function add(String $modelName, array $configurationSet)
    {
        if (class_exists($className = ('App\Models\Settings\\' . ucfirst($modelName) . 'Settings'))) {
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
}
