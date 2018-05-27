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
 * Class Permission.
 *
 * Permissions are rights modules from RAISe
 * they are useful to grant special conditions or "permissions"
 * to a group.
 *
 * @version 2.1.0
 *
 * @since 2.0.0
 */
class Permission extends Model
{
    /**
     * The permission name.
     *
     * The name describes an understandable API
     * name for the permission.
     *
     * eg.: CONTEXT_READ
     *
     * @required
     *
     * @rule uniqueName
     *
     * @var string
     */
    public $name;

    /**
     * The Description of the Permission.
     *
     * eg.: "This permission grants that a Client
     *  can register data to it's context"
     *
     * @required
     *
     * @var string
     */
    public $description = 'No description given.';
}
