<?php

/**
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

namespace App\Handlers;

use App\Factories\Settings as SettingsFactory;

/**
 * Class Settings.
 *
 * A Settings Handler manages the set of Settings that are stored on the Factory,
 * retrieves it, does find algorithms, and many other things
 *
 * @see https://en.wikipedia.org/wiki/Chain-of-responsibility_pattern CR Design Pattern
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Settings
{
	/**
	 * Get a Configuration Element from a Settings Model.
	 *
	 * @param string $configuration the configuration string or model to search
	 *
	 * @return bool|mixed the entire settings model or a value of a settings entry
	 */
	public static function get(string $configuration)
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
	 * @param array $settings the entire set of settings block
	 */
	public static function store(array $settings)
	{
		array_walk($settings, function ($settingModel, $settingName) {
			self::add($settingName, $settingModel);
		});
	}

	/**
	 * Tries to Add a SettingsModel with given Attributes.
	 *
	 * Return true if created with success and if class exists, false if it not exists
	 *
	 * @param string $modelName the model name
	 * @param array $configurationSet the configuration set
	 *
	 * @return bool
	 */
	public static function add(string $modelName, array $configurationSet)
	{
		return SettingsFactory::add($modelName, $configurationSet);
	}
}
