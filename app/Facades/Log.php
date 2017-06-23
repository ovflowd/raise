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

namespace App\Facades;

use App\Factories\Log as LogFactory;

/**
 * Class Log.
 *
 * (Actually a Facade, but Manages the Logs)
 *
 * A Manager is a Mediator, it does specific processes and operations
 * to make everything available and functional for the rest of the components.
 *
 * A Log Manager manages the I/O of the Logs and their availability and data.
 *
 * @see https://en.wikipedia.org/wiki/Mediator_pattern Mediator Design Pattern
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Log extends Facade
{
    /**
     * Add a Log Entry on the Database
     *
     * @param string $element Unique Identifier of the Inserted Element (if exists)
     * @param string $table Related Table of the Operations related to this Log entry
     * @param string $details Details upon the Operation behind the Log
     * @param string|null $givenToken A Token (JWT) can also be given
     *
     * @return bool|string If added successfully the log entry, if not false.
     */
    public static function add(string $element, string $table, string $details, string $givenToken = null)
    {
        global $token;

        $content = [
            'token' => ($token(false) ?: $givenToken),
            'element' => $element,
            'table' => $table,
            'details' => $details
        ];

        $time = microtime(true);

        return LogFactory::add("log-{$table}-{$time}", $content);
    }
}
