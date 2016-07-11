<?php

namespace UIoT\util;

use Symfony\Component\HttpFoundation\Request;
use UIoT\control\ResourceController;
use UIoT\database\DatabaseManager;
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
        $this->resourceController = new ResourceController($this->getResources(), $this->databaseManager);
        $this->tokenManager = new UIoTToken($this->databaseManager);
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
    private function setResponseData(Request $requestData = null)
    {
        $this->responseData = new UIoTResponse();
        $this->responseData->prepare($requestData == null ? $this->requestData : $requestData);
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

        if (!$request->query->has("token") && $request->getResource() == "devices" && $request->getMethod() == "POST") {

            $response = $this->resourceController->executeRequest($request);
            $id = $this->databaseManager->getLastId();

            if ($id > 0) {
                $token = $this->tokenManager->defineToken($id);

                // TODO: Hard Coded (Message System)
                return ["code" => 200, "token" => $token];
            }

            return $response;
        } else if ($this->tokenManager->validateCode($request->query->get("token"))) {

            $this->tokenManager->updateTokenExpire($request->query->get("token"));

            if ($request->getResource() == "services" && $request->getMethod() == "POST") {
                $response = $this->resourceController->executeRequest($request);
                $serviceId = $this->databaseManager->getLastId();

                if ($serviceId > 0) {
                    $tokenId = $this->tokenManager->getDeviceIdFromToken($request->query->get("token"));

                    $serviceName = $request->query->get("name");
                    $serviceType = $request->query->get("type");

                    $this->databaseManager->fastExecute("INSERT INTO actions VALUES (NULL, :act_name, :act_type, '', '0')",
                        [':act_name' => $serviceName, ':act_type' => $serviceType]);

                    $actionId = $this->databaseManager->getLastId();

                    $this->databaseManager->fastExecute("INSERT INTO service_actions VALUES (:srvc_id, :act_id, '0')",
                        [':srvc_id' => $tokenId, ':act_id' => $actionId]);

                    return ["code" => 200, "service_id" => $serviceId, "device_id" => $tokenId];
                } else {
                    return $response;
                }
            } else {
                return $this->resourceController->executeRequest($request);
            }
        } else {
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

        foreach ($this->databaseManager->action('SELECT * FROM META_RESOURCES') as $resource) {
            $resources[$resource->RSRC_FRIENDLY_NAME] = new MetaResource($resource->ID, $resource->RSRC_ACRONYM,
                $resource->RSRC_NAME, $resource->RSRC_FRIENDLY_NAME, $this->getResourceProperties($resource->ID));
        }

        return $resources;
    }

    /**
     * Get Resource Properties
     *
     * @param integer $resourceId
     * @return array
     */
    private function getResourceProperties($resourceId)
    {
        $properties = array();

        foreach ($this->databaseManager->action('SELECT * FROM META_PROPERTIES WHERE RSRC_ID = :resource_id', [':resource_id' => $resourceId]) as $property) {
            $properties[$property->PROP_FRIENDLY_NAME] = new MetaProperty($property->ID,
                $property->PROP_NAME, $property->PROP_FRIENDLY_NAME);
        }

        return $properties;
    }
}
