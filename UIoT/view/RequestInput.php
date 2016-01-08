<?php

namespace UIoT\view;

use UIoT\control\RequestController;
use UIoT\model\Request;
use UIoT\util\RequestRouter;

/**
 * Class RequestInput
 *
 * @package UIoT\view
 * @property RequestController $requestControl
 * @property RequestRouter $requestRouter
 */
class RequestInput
{
    /**
     * @var RequestController
     */
    var $requestControl;
    /**
     * @var RequestRouter
     */
    var $requestRouter;

    /**
     * RequestInput constructor.
     */
    public function __construct()
    {
        self::setRequestControl(new RequestController());
        self::setRequestRouter(new RequestRouter());
    }

    /**
     * Sets the request controller attribute | @see $requestControl
     *
     * @param RequestController $requestControl
     */
    private function setRequestControl(RequestController $requestControl)
    {
        $this->requestControl = $requestControl;
    }

    /**
     * Sets the request router attribute | @see $requestRouter
     *
     * @param RequestRouter $requestRouter
     */
    private function setRequestRouter(RequestRouter $requestRouter)
    {
        $this->requestRouter = $requestRouter;
    }

    /**
     * Starts the Request creation and submission process
     *
     * @return array|bool|string
     */
    public function start()
    {
        return self::submitRequest();
    }

    /**
     * Creates and submits a Request | @see Request.php
     *
     * @return array|bool|string
     */
    private function submitRequest()
    {
        $request = self::createRequestObject();

        if (self::isValid($request))
            return $this->requestRouter->submitRequest($request);
        else
            return $request->getErrorStatus();
    }

    /**
     * Creates a Request | @see Request.php
     *
     * @return Request
     */
    private function createRequestObject()
    {
        return $this->requestControl->createRequest(
            self::getRequestUri(),
            self::getRequestMethod(),
            self::getRequestProtocol(),
            self::getRequestScriptName());
    }

    /**
     * Gets the request's uri
     *
     * @return array
     */
    private function getRequestUri()
    {
        return explode('/', $_SERVER['REQUEST_URI']);
    }

    /**
     * Gets the request's method
     *
     * @return string
     */
    private function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Gets the request's protocol
     *
     * @return string
     */
    private function getRequestProtocol()
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    /**
     * Gets the request's script name
     *
     * @return array
     */
    private function getRequestScriptName()
    {
        return explode('/', $_SERVER['SCRIPT_NAME']);
    }

    /**
     * Returns whether or not a request is valid
     *
     * @param Request $request
     * @return bool
     */
    private function isValid(Request $request)
    {
        return (is_a($request, 'UIoT\model\Request') && is_null($request->getErrorStatus()));
    }
}