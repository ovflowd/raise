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
 * Class Raise.
 *
 * The RAISe Model is a Base Model used as definition of data
 * that will be stored on the Database
 *
 * This Model contains all items that are by default
 * stored on a Document
 *
 * @version 2.1.0
 *
 * @since 2.0.0
 */
abstract class Raise extends Model
{
    /**
     * The time when the Client requested the operation.
     *
     * @rule clientTime
     */
    public $clientTime = 0;

    /**
     * Tags Identifiers.
     *
     * Tags are used to contextual data filtering
     * and may be used to filter set of results
     *
     * @var string[]
     */
    public $tags = [];

    /**
     * The time when the server handled the operation and inserted it.
     *
     * @rule serverTime
     */
    public $serverTime = 0;

    /**
     * Base RAISe Model Constructor
     *
     * Prepares the Timestamps and other Default Stuff
     */
    public function __construct()
    {
        $this->clientTime = microtime(true);
        $this->serverTime = microtime(true);
    }
}
