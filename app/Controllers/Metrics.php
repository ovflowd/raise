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

use App\Models\Communication\Client as ClientDefinition;
use App\Models\Communication\Model;
use App\Models\Response\Client as ClientResponse;
use App\Models\Response\Token as TokenResponse;
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
        response()::content('text/html');
    }

    /**
     * List Page.
     *
     * Show a View containing all Clients
     */
    public function list()
    {
        response()::content('text/html');
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
        response()::content('text/html');
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
        response()::content('text/html');
    }
}
