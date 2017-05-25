<?php

namespace App\Controllers;

use App\Facades\RequestFacade;
use App\Facades\SecurityFacade;
use App\Managers\DatabaseManager;
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
        if (SecurityFacade::validateBody('client', RequestFacade::body()) == false) {
            ResponseManager::get()->setResponse(400, 'Missing required Parameters');

            return;
        }

        $token = SecurityFacade::generateToken();

        SecurityFacade::insertToken($token, DatabaseManager::getConnection()->insert('client', RequestFacade::body()));

        ResponseManager::get()->setResponse(200, $token);
    }

    /**
     * List Process.
     *
     * @return mixed
     */
    public function list()
    {
        //TODO function
    }
}
