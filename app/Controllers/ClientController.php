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
        if (($mappedModel = SecurityFacade::validateBody('client', RequestFacade::body())) == false) {
            ResponseManager::get()->setResponse(400, 'Missing required Parameters');

            return;
        }

        ResponseManager::get()->setResponseModel(200, new TokenResponse, array(
            'message' => 'Client Registered Successfully',
            'token' => SecurityFacade::insertToken(DatabaseManager::getConnection()->insert('client', $mappedModel))
        ));
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
