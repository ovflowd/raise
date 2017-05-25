<?php

namespace App\Controllers;

use App\Facades\RequestFacade;
use App\Facades\SecurityFacade;
use App\Managers\ResponseManager;
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
        $result = SecurityFacade::validateParams('POST', 'client', RequestFacade::body());

        if ($result == false) {
            ResponseManager::get()->setResponse(400, "Missing required Parameters");

            return false;
        }
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
