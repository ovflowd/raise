<?php

namespace UIoT\control;

use UIoT\model\HTTPStatus;
use UIoT\model\Request;

/**
 * Class RequestControl
 *
 * @package UIoT\control
 * @property string[] $methods
 * @property string[] $resources
 */
final class RequestController
{

    /**
     * @var string[] Request methods(Get, Post, Put and Delete).
     */
    private $methods = array('GET', 'POST', 'PUT', 'DELETE');

    /**
     * @var string[] Request resources.
     */
    private $resources = array('slave_controllers', 'devices', 'services', 'actions', 'state_variables', 'resources');

    /**
     * Creates a Request object.
     * 
     * @param string $requestUri
     * @param string $requestMethod
     * @param string $serverProtocol
     * @param string $scriptName
     * @return Request
     */
    public function createRequest($requestUri, $requestMethod, $serverProtocol, $scriptName)
    {
        $request = new Request($requestUri, $requestMethod, $serverProtocol, $scriptName);

        if (!self::isValidRequest($request))
            $request->setErrorStatus(new HTTPStatus(403, null));

        return $request;
    }

    /**
     * Returns whether or not a request is valid.
     * 
     * @param Request $request
     * @return bool
     */
    public function isValidRequest(Request $request)
    {
        return self::hasValidMethod($request) && self::hasValidResource($request) && self::isUriOrParametersBased($request);
    }

    /**
     * Returns whether or not a request contains a valid method.
     * 
     * @param Request $request
     * @return bool
     */
    private function hasValidMethod(Request $request)
    {
        return in_array($request->getMethod(), $this->methods);
    }

    /**
     * Returns whether or not a request has a valid resource.
     *
     * @param Request $request
     * @return bool
     */
    private function hasValidResource(Request $request)
    {
        return in_array($request->getResource(), $this->resources);
    }

    /**
     * Returns if a request is uri or parameter based.
     *
     * @param Request $request
     * @return bool
     */
    private function isUriOrParametersBased(Request $request)
    {
        return !($request->hasParameters() && $request->hasComposedUri());
    }
}
