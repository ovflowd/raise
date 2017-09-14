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
 * Class Profile.
 *
 * A Profile Model it's related to a Profile Document,
 * Profiles are Groups of Permissions and Relations.
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Profile extends Model
{
    /**
     * The Name of the Group.
     *
     * eg. Administrators, Clients, Managers
     *
     * @required
     *
     * @var string
     */
    public $name;

    /**
     * The unique name of the Group
     * used to identify in access.
     *
     * @required
     *
     * @var string
     */
    public $uniqueName;

    /**
     * The Description of the Group.
     *
     * eg. "Clients are the users of RAISe"
     *
     * @var string|null
     */
    public $description = null;

    /**
     * The type of the Group is used
     *  to define the behaviour of the group.
     *
     * By default the following group types are available:
     * 1. "access" -> used to specify that this group is used to specify
     *  a type of user. Eg.: "Administrator", "Client"
     * 2. "relation" -> used to define relations between
     *  clients of the system. Eg.: "Gardening Devices of my House"
     *
     * @var string
     */
    public $type = 'access';

    /**
     * The Permissions of this Group,
     * Permissions are granted to each group.
     *
     * @see Permission
     *
     * @required
     *
     * @var array|null
     */
    public $permissions = [];

    /**
     * Relations it's an optional parameter
     * and are the directly affected members of the group.
     *
     * Depending of the purpose of the group, directly relations
     *  aren't required. Like Access Groups.
     *
     * @var array|null
     */
    public $relations = [];

    /**
     * Set the Unique Name of the Group.
     *
     * This method verifies if already exists a Group
     *  with this Unique Name, if not allows to store,
     *  if yes, throws an error.
     *
     * Also if the unique name has numbers or special characters
     *  or even white space also throws an exception
     *
     * @param string $name
     *
     * @throws JsonMapper_Exception
     */
    public function setUniqueName(string $name)
    {
        // Check if Group Exists
        if (security()::group($name) !== false) {
            throw new JsonMapper_Exception('Already exists a group with this unique name.');
        }

        // Check if unique name is alphabetic only
        if (preg_match('/^[a-z_]*$/', $name) === 0) {
            throw new JsonMapper_Exception('Only alphabet characters and hyphens are allowed');
        }

        $this->uniqueName = $name;
    }

    /**
     * Set the Permissions of this Group.
     *
     * this method verifies if the permission names stored
     *  on the $permissions array is fullified with valid permissions
     *
     * Note.: The array need contains the name
     *  of the permissions.
     *
     * Note.: this method throws an exception any of the permissions
     *  provided aren't valid.
     *
     * @param array $permissions the array of permissions names
     */
    public function setPermissions(array $permissions = [])
    {
        array_walk($permissions, function (string $permission) {
            if (security()::permission($permission) === false) {
                throw new JsonMapper_Exception('One or more permissions provided doesn\'t exists.');
            }
        });

        $this->permissions = $permissions;
    }
}
