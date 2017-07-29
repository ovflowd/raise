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
    public function index()
    {
        response()::type('text/html');

        view()::add('metrics.header');
        view()::add('metrics.index');
        view()::add('metrics.footer');
    }

    /**
     * List Page.
     *
     * Show a View containing all Clients
     */
    public function list()
    {
        response()::type('text/html');

        $clients = '';

        foreach (database()->select('client', new Select()) as $client) {
            $tags = empty($client->document->tags) ? 'No Tags' : implode(', ', $client->document->tags);

            $clients .= "<li><div class='callout primary'>" .
                "<a href='client/{$client->document->serverTime}' style='float:right' class='see-button'>Watch</a>" .
                "<h5>{$client->document->name}</h5>[{$tags}]</div></li>";
        }

        view()::add('metrics.header');
        view()::add('metrics.list', ['{{clients}}' => $clients]);
        view()::add('metrics.footer');
    }

    /**
     * Client Page.
     *
     * Show a Specific Client
     *
     * @param string $client The client to be hooked
     */
    public function client(string $client)
    {
        response()::type('text/html');

        view()::add('metrics.header');
        view()::add('metrics.index');
        view()::add('metrics.footer');
    }

    /**
     * Data Page.
     *
     * Show a Specific Client Data
     *
     * @param string $client The client to be hooked
     */
    public function data(string $client)
    {
        response()::type('text/html');
    }
}
