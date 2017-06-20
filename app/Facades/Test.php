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

use App\Handlers\Settings;
use PHPUnit\Framework\TestCase;

/**
 * Class Test.
 *
 * A Standard Test Case for RAISe
 * testing and procedures
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
abstract class Test extends TestCase
{
    /**
     * Configure a RAISe Test Case.
     *
     * Emulates a RAISe scenario with standard Data
     * configured on the Continuous Integration Environments
     * without requesting HTTP Requests
     *
     * @param array  $headers The HTTP Headers
     * @param string $method  The Request Method
     * @param array  $server  The php's $_SERVER environment
     * @param string $path    Execution Path
     */
    protected function configureRaise(array $headers, string $method, array $server, string $path = '')
    {
        global $settings;

        $server['REQUEST_URI'] = $path;
        $server['REQUEST_METHOD'] = $method;
        $server['SERVER_PROTOCOL'] = 'http';
        $server['SCRIPT_NAME'] = '/index.php';

        $_SERVER = $server;

        request()::prepare($headers, $method, $server);

        response()::prepare();

        Settings::store($settings);
    }

    /**
     * RAISe Eexutor method.
     *
     * Execute's RAISe Router
     * and let the User add a Request Body
     *
     * @param object|\stdClass|null $body Desired Request Body
     */
    protected function executeRaise($body = null)
    {
        // Globalize the Variables
        global $router;

        // Set a Body
        request()::setBody($body);

        // Run the Route and set a Callback
        $router()->run();
    }
}
