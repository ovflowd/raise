<?php

namespace UIoT\view;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UIoT\control\RequestController;
use UIoT\model\UIoTRequest;
use UIoT\model\UIoTResponse;
use UIoT\util\ExceptionHandler;
use UIoT\util\RequestRouter;

/**
 * Class RequestInput
 *
 * @package UIoT\view
 *
 * @property RequestController $requestControl
 * @property RequestRouter $requestRouter
 * @property UIoTRequest $requestData
 * @property Response $responseData
 */
class RequestInput
{
    /**
     * @var RequestController
     */
    private $requestControl;

    /**
     * @var RequestRouter
     */
    private $requestRouter;

    /**
     * @var UIoTRequest
     */
    private $requestData;

    /**
     * @var UIoTResponse
     */
    private $responseData;

    /**
     * RequestInput constructor.
     */
    public function __construct()
    {
        self::registerExceptionHandler();

        self::setRequestControl(new RequestController());

        self::setRequestRouter(new RequestRouter());

        self::setRequestData(UIoTRequest::createFromGlobals());

        self::getRequestData()->setRequestValidation();

        self::getRequestData()->assignRequestData();

        self::setResponseData();
    }

    /**
     * Register Exception Handler
     */
    private function registerExceptionHandler()
    {
        set_exception_handler(array(ExceptionHandler::getInstance(), 'handleException'));
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
     * Set Current Request Data
     *
     * @param Request $requestData
     */
    private function setRequestData(Request $requestData)
    {
        $this->requestData = $requestData;
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
     * Starts the Request creation and submission process
     *
     * @return array|bool|string
     */
    public function route()
    {
        return $this->requestRouter->submitRequest($this->requestControl->createRequest($this));
    }
}