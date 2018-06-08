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

/**
 * Class Profile.
 *
 * A Profile Model it's related to a Profile Document,
 * Profiles are Groups of Permissions and Relations.
 *
 * @version 2.1.0
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
     * @rule uniqueName
     *
     * @var string
     */
    public $uniqueName;

    /**
     * The Description of the Group.
     *
     * eg. "Clients are the users of RAISe"
     *
     * @var string
     */
    public $description = 'No description given.';

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
     * @var string[]
     */
    public $permissions = [];

    /**
     * Relations it's an optional parameter
     * and are the directly affected members of the group.
     *
     * Depending of the purpose of the group, directly relations
     *  aren't required. Like Access Groups.
     *
     * @var string[]
     */
    public $relations = [];
}
