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
     * @return void
     */
    public function register()
    {
        $model = RequestFacade::body();

        if (SecurityFacade::validateBody('client', $model) == false) {
            ResponseManager::get()->setResponse(400, 'Missing required Parameters');

            return;
        }

        $token = SecurityFacade::generateToken();

        $model->serverTime = microtime(true);

        SecurityFacade::insertToken($token, DatabaseManager::getConnection()->insert('client', $model));

        ResponseManager::get()->setResponse(200, $token);
    }

    /**
     * List Process.
     *
     * @return void
     */
    public function list()
    {
        //TODO function
    }
}
