<?php

namespace UIoT\util;

use Symfony\Component\HttpFoundation\Request;
use UIoT\control\ResourceController;
use UIoT\database\DatabaseHandler;
use UIoT\database\DatabaseManager;
use UIoT\messages\DatabaseErrorFailedMessage;
use UIoT\messages\InvalidRaiseResourceMessage;
use UIoT\messages\InvalidTokenMessage;
use UIoT\model\MetaProperty;
use UIoT\model\MetaResource;
use UIoT\model\UIoTRequest;
use UIoT\model\UIoTResponse;
use UIoT\model\UIoTToken;

/**
 * Class RequestInput
 * @package UIoT\util
 */
class RequestInput
{
    /**
     * @var UIoTRequest
     */
    private $requestData;

    /**
     * @var UIoTResponse
     */
    private $responseData;

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @var DatabaseHandler
     */
    private $databaseHandler;

    /**
     * @var ResourceController
     */
    private $resourceController;

    /**
     * @var UIoTToken
     */
    private $tokenManager;

    /**
     * RequestInput constructor.
     */
    public function __construct()
    {
        $this->databaseManager = new DatabaseManager();
        $this->databaseHandler = new DatabaseHandler();
        $this->resourceController = new ResourceController($this->getResources(), $this->databaseHandler);
        $this->tokenManager = new UIoTToken($this->databaseHandler->getInstance());
        $this->requestData = UIoTRequest::createFromGlobals();

        $this->registerExceptionHandler();
        $this->getRequestData()->assignRequest();
        $this->setResponseData();
    }

    /**
     * Register Exception Handler
     */
    private function registerExceptionHandler()
    {
        set_exception_handler(array(MessageHandler::getInstance(), 'getMessage'));
    }

    /**
     * Set Response based on his Request
     *
     * @param Request $requestData
     */
    private function setResponseData(Request $requestData = NULL)
    {
        $this->responseData = new UIoTResponse();
        $this->responseData->prepare($requestData == NULL ? $this->requestData : $requestData);
    }

    /**
     * Get Request Data
     *
     * @return UIoTRequest
     */
    public function getRequestData()
    {
        return $this->requestData;
    }

    /**
     * Get Response Data
     *
     * @return UIoTResponse
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * Route Raise
     *
     * @return mixed
     */
    public function route()
    {
        $request = $this->getRequestData();
        
        if (!in_array($request->getResource(), $this->getResourceNames()))
            MessageHandler::getInstance()->endExecution(new InvalidRaiseResourceMessage);

        // TODO: Refactoring

        if(!$request->query->has("token") && $request->getResource() == "devices" && $request->getMethod() == "POST")
        {
            $response = $this->resourceController->executeRequest($request);
            $id = $this->databaseHandler->getInstance()->lastInsertId();
            if($id > 0) {
                $token = $this->tokenManager->defineToken($id);
                return ["code" => 200, "token" => $token];
            } else {
                return $response;
            }
        }
        else if($this->tokenManager->validateCode($request->query->get("token"))) {

            $this->tokenManager->updateTokenExpire($request->query->get("token"));

            if($request->getResource() == "services" && $request->getMethod() == "POST"){
                $response = $this->resourceController->executeRequest($request);
                $service_id = $this->databaseHandler->getInstance()->lastInsertId();

                if($service_id > 0) {
                    $tokenId = $this->tokenManager->getDeviceIdFromToken($request->query->get("token"));

                    $service_name = $request->query->get("name");
                    $service_type = $request->query->get("type");

                    $add_service_action = $this->databaseHandler->getInstance()->prepare("INSERT INTO actions VALUES (NULL, :act_name, :act_type, '', '0');"); // ACT_NAME, ACT_TYPE, ACT_DATA_TYPE
                    $add_service_action->bindParam(":act_name", $service_name);
                    $add_service_action->bindParam(":act_type", $service_type);
                    $add_service_action->execute();

                    $action_id = $this->databaseHandler->getInstance()->lastInsertId();

                    $add_link_service_action = $this->databaseHandler->getInstance()->prepare("INSERT INTO service_actions VALUES (:srvc_id, :actid, '0');");
                    $add_link_service_action->bindParam(":srvc_id", $service_id);
                    $add_link_service_action->bindParam(":actid", $action_id);
                    $add_link_service_action->execute();

                    return ["code" => 200, "service_id" => $service_id, "device_id" => $tokenId];
                } else {
                    return $response;
                }
            }
            else {
                return $this->resourceController->executeRequest($request);
            }
        }
        else {
            MessageHandler::getInstance()->endExecution(new InvalidTokenMessage);
        }
    }

    /**
     * Get friendly name from getResources array
     *
     * @return array
     */
    private function getResourceNames()
    {
        $names = [];
        foreach ($this->getResources() as $resource) {
            $names[] = $resource->getFriendlyName();
        }

        return $names;
    }

    /**
     * Get Resources
     *
     * @return array
     */
    private function getResources()
    {
        $resources = array();

        foreach ($this->databaseManager->execute('SELECT * FROM META_RESOURCES',
            $this->databaseHandler->getInstance()) as $resource) {
            $resources[$resource->RSRC_FRIENDLY_NAME] = new MetaResource($resource->ID, $resource->RSRC_ACRONYM, $resource->RSRC_NAME, $resource->RSRC_FRIENDLY_NAME, $this->getResourceProperties($resource->ID));
        }

        return $resources;
    }

    /**
     * Get Resource Properties
     *
     * @param $resourceId
     * @return array
     */
    private function getResourceProperties($resourceId)
    {
        $properties = array();

        foreach ($this->databaseManager->execute("SELECT * FROM META_PROPERTIES WHERE RSRC_ID = {$resourceId}",
            $this->databaseHandler->getInstance()) as $property) {
            $properties[$property->PROP_FRIENDLY_NAME] = new MetaProperty($property->ID, $property->PROP_NAME, $property->PROP_FRIENDLY_NAME);
        }

        return $properties;
    }
}
