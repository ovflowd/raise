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

namespace App\Controllers;

use App\Models\Communication\Chart;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class Metrics.
 *
 * A Controller that Manages all Routes and Business Logic
 *  from the Metrics Resources
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Metrics extends Controller
{
    /**
     * Index Page.
     *
     * Show a Welcoming Page
     */
    public function welcome()
    {
        response()::type('text/html');

        blade()::make('header.welcome');
        blade()::make('body.menu');
        blade()::make('body.welcome');
    }

    /**
     * List Page.
     *
     * Show a View containing a Dashboard with
     * Clients, Logs, and more
     */
    public function home()
    {
        response()::type('text/html');

        $clients = database()->select('client', new Select());
        $logs = database()->select('log', (new Select())->limit(100));

        blade()::make('header.home');
        blade()::make('body.menu');
        blade()::make('body.home', ['clients' => $clients, 'logs' => $logs]);
        blade()::make('footer.home');
    }

    /**
     * Client Page.
     *
     * Show a Specific Client
     *
     * @param string $id The client to be hooked
     */
    public function client(string $id)
    {
        response()::type('text/html');

        $client = database()->selectById('client', $id);
        $client->id = $id;
        $client->location = explode(':', $client->location);

        $services = database()->select('service', (new Select())->where('clientId', $id));

        $data = array_map(function ($service) {
            return json()::map(new Chart(), [
                'label' => $service->document->name,
                'data'  => database()->select('data', (new Select())->where('serviceId',
                    $service->id)->orderBy('clientTime', 'desc')->limit(100)),
            ]);
        }, $services);

        blade()::make('header.client');
        blade()::make('body.menu');
        blade()::make('body.client', ['services' => $services, 'client' => $client]);
        blade()::make('footer.client',
            ['latitude' => $client->location[0], 'longitude' => $client->location[1], 'data' => $data]);
    }

    /**
     * Data Page.
     *
     * Show a Specific Service Data
     *
     * @param string $id The service to be hooked
     */
    public function data(string $id)
    {
        response()::type('text/html');

        $service = database()->selectById('service', $id);

        $data = database()->select('data', (new Select())->where('serviceId', $id));

        blade()::make('header.data');
        blade()::make('body.menu');
        blade()::make('body.data', ['data' => $data, 'service' => $service]);
        blade()::make('footer.data');
    }
}
