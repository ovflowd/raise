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

namespace App\Models\Communication;

use JsonMapper_Exception;

/**
 * Class Permission.
 *
 * Permissions are rights modules from RAISe
 * they are useful to grant special conditions or "permissions"
 * to a group.
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Permission extends Model
{
    /**
     * The permission name
     *
     * The name describes an understandable API
     * name for the permission.
     *
     * eg.: CONTEXT_READ
     *
     * @required
     *
     * @var string
     */
    public $name;

    /**
     * The Description of the Permission
     *
     * eg.: "This permission grants that a Client
     *  can register data to it's context"
     *
     * @required
     *
     * @var string
     */
    public $description;

    /**
     * Set the Name of the Permission
     *
     * This method verifies if already exists a Permission
     *  with this name, if not allows to store,
     *  if yes, throws an error.
     *
     * Also if the unique name has numbers or special characters
     *  or even white space also throws an exception
     *
     * @param string $name
     *
     * @throws JsonMapper_Exception
     */
    public function setName(string $name)
    {
        // Check if Group Exists
        if (security()::group($name) !== false) {
            throw new JsonMapper_Exception('Already exists a group with this unique name.');
        }

        // Check if unique name is alphabetic only
        if (preg_match('/[^a-z_\-]/i', $name) !== false) {
            throw new JsonMapper_Exception('Only alphabet characters and hyphens are allowed');
        }

        $this->name = $name;
    }
}
