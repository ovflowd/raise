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

/**
 * Class Manage.
 *
 * A Controller that Manages the Management Routes
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Manage extends Controller
{
    /**
     * Login Page.
     *
     * Show a Login Page
     */
    public function login()
    {
        response()::type('text/html');

        view()::add('login');
    }
}
