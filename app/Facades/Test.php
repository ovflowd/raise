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
use App\Models\Communication\Client as ClientModel;
use App\Models\Communication\Data as DataModel;
use App\Models\Communication\Service as ServiceModel;
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

    /**
     * @param ClientModel|null $model
     *
     * @return \App\Models\Communication\Model|array|object|string
     */
    protected function createClient(ClientModel $model = null)
    {
        $this->configureRaise(['Content-Type' => 'application/json'],
            'POST', $_SERVER, '/client/register');

        $clientModel = (object) [
            'name'       => 'Sample Test',
            'chipset'    => '0.0',
            'mac'        => 'FF:FF:FF:FF:FF',
            'serial'     => 'm3t41xR3l02d3d',
            'processor'  => 'AMD SUX-K2',
            'channel'    => 'ieee-4chan(nel)-802154',
            'location'   => '0:0',
            'clientTime' => microtime(true),
        ];

        $model = is_null($model) ? $clientModel : $model;

        $this->executeRaise($model);

        return response()::response();
    }

    /**
     * @param null              $token
     * @param ServiceModel|null $model
     *
     * @return \App\Models\Communication\Model|array|object|string
     */
    protected function createService($token, ServiceModel $model = null)
    {
        $this->configureRaise(['Content-Type' => 'application/json', 'authorization' => $token],
            'POST', $_SERVER, '/service/register');

        $serviceModel = [
            (object) [
                'clientTime' => microtime(true),
                'tags'       => ['example-tag'],
                'name'       => 'Get temp',
                'parameters' => ['humidity', 'temperature'],
                'returnType' => 'float',
            ],
        ];

        $model = is_null($model) ? $serviceModel : $model;

        $this->executeRaise($model);

        return response()::response();
    }

    /**
     * @param null      $serviceId
     * @param null      $token
     * @param DataModel $model
     *
     * @return \App\Models\Communication\Model|array|object|string
     */
    protected function createData($serviceId, $token, DataModel $model = null)
    {
        $this->configureRaise(['Content-Type' => 'application/json', 'authorizaion' => $token],
            'POST', $_SERVER, '/data/register');

        $dataModel = [
            (object) [
                'clientTime' => microtime(true),
                'tags'       => ['example-tag'],
                'serviceId'  => $serviceId,
                'order'      => ['humidity', 'temperature'],
                'values'     => [['20.2', '30']],
            ],
        ];

        $model = is_null($model) ? $dataModel : $model;

        $this->executeRaise($model);

        return response()::response();
    }
}
