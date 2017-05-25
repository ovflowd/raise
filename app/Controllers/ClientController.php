<?php

namespace App\Controllers;

use App\Facades\RequestFacade;
use App\Facades\SecurityFacade;
use App\Models\Interfaces\Controller;

/**
 * Class ClientController.
 */
class ClientController implements Controller
{
    /**
     * Register Process.
     *
     * @return mixed
     */
    public function register()
    {
        SecurityFacade::validateParams('POST', 'client', RequestFacade::body());
    }

    /**
     * List Process.
     *
     * @return mixed
     */
    public function list()
    {
        // TODO: Implement list() method.
    }
}
