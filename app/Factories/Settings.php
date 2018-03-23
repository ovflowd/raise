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

namespace App\Factories;

/**
 * Class Settings.
 *
 * This is a Factory used to store Settings Models
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Settings extends Factory
{
	/**
	 * Get an Element.
	 *
	 * If the element exists return in,
	 * If not return a false boolean.
	 *
	 * @param string $element name of the element
	 *
	 * @return object|array|bool the element or false if didn't found it
	 */
	public static function get(string $element)
	{
		return array_key_exists($element, self::instance()->elements)
			? self::instance()->elements[$element] : false;
	}

	/**
	 * Add an Settings Model.
	 *
	 * Return true if added with success, false if element already exists
	 *
	 * @param string $element desired Settings Model to add
	 * @param array|object $content the content that will be mapped
	 *
	 * @return bool true if added successfully, false if already exists
	 */
	public static function add(string $element, $content)
	{
		$class = ('App\Models\Settings\\' . ucwords($element));

		if (!array_key_exists($element, self::instance()->elements) && class_exists($class)) {
			self::instance()->elements[$element] = json()::map($class, $content);

			return true;
		}

		return false;
	}

	/**
	 * Remove an Element.
	 *
	 * Return true if removed with success, false if element doesn't exists
	 *
	 * @param string $element the element to be removed
	 *
	 * @return bool if removed successfully or not
	 */
	public static function remove(string $element)
	{
		if (array_key_exists($element, self::instance()->elements)) {
			unset(self::instance()->elements[$element]);

			return true;
		}

		return false;
	}
}
