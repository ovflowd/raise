<?php

namespace App\Controllers;

use App\Facades\RequestFacade;
use App\Facades\SecurityFacade;
use App\Managers\DatabaseManager;
use App\Managers\ResponseManager;
use App\Models\Interfaces\Controller;
use App\Models\Response\TokenResponse;

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

        ResponseManager::get()->setModel(200,
            (new TokenResponse())->fill(['message' => 'Client Inserted Successfully', 'token' => $token]));
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
