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

use App\Models\Response\Log as LogResponse;

/**
 * Class Log.
 *
 * A Factory that will be used to Manage Log Entries
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Log extends Factory
{
	/**
	 * Get an Log Entry.
	 *
	 * If the element exists return in,
	 * If not return a false boolean.
	 *
	 * @param string $element unique identifier of the log entry
	 *
	 * @return object|array|bool the log entry or false if didn't found it
	 */
	public static function get(string $element)
	{
		return database()->select('log', $element);
	}

	/**
	 * Add an Log entry.
	 *
	 * @param string $element the unique identifier of the log
	 * @param array|object $content the content of the element
	 *
	 * @return bool|string the unique identifier if added successfully or false if not
	 */
	public static function add(string $element, $content)
	{
		return database()->insert('log', json()::map(new LogResponse(), $content), $element);
	}

	/**
	 * Remove an Element.
	 *
	 * Logs aren't removable so will return false in any case
	 *
	 * @param string $element the element to be removed
	 *
	 * @return bool if removed successfully or not
	 */
	public static function remove(string $element)
	{
		return false;
	}
}
