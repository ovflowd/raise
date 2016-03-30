<?php

namespace UIoT\util;

use UIoT\control\RequestController;
use UIoT\model\UIoTRequest;

final class RequestValidation
{
    /**
     * Request Data
     *
     * @var UIoTRequest
     */
    private $requestData;

    /**
     * Set Request Data
     *
     * @param UIoTRequest $request
     */
    public function __construct(UIoTRequest $request)
    {
        $this->requestData = $request;
    }

    /**
     * Returns whether or not a request is valid.
     *
     * @param RequestController $requestData
     *
     * @return bool
     */
    public function isValidRequest(RequestController $requestData)
    {
        return $this->hasValidMethod($requestData->getMethods()) && $this->hasValidResource($requestData->getResources()) && $this->isUriOrParametersBased();
    }

    /**
     * Returns whether or not a request contains a valid method.
     *
     * @param array $acceptableMethods
     *
     * @return bool
     */
    public function hasValidMethod(array $acceptableMethods)
    {
        return in_array($this->requestData->getMethod(), $acceptableMethods);
    }

    /**
     * Returns whether or not a request has a valid resource.
     *
     * @param array $acceptableResources
     *
     * @return bool
     */
    public function hasValidResource(array $acceptableResources)
    {
        return in_array($this->requestData->getResource(), $acceptableResources);
    }

    /**
     * Returns if a request is uri or parameter based.
     *
     * @return bool
     */
    public function isUriOrParametersBased()
    {
        return !($this->hasParameters() && $this->hasValidUrl());
    }

    /**
     * Check Existence of Query String
     *
     * @return bool
     */
    public function hasParameters()
    {
        return count($this->requestData->getRequestUriData()->getQuery()->getData()) > 0;
    }

    /**
     * Check if Uri has More Than One Path
     *
     * @return bool
     */
    public function hasValidUrl()
    {
        return count($this->requestData->getRequestUriData()->getPath()->getData()) <= 1;
    }
}