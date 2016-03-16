<?php

namespace UIoT\control;

use Symfony\Component\HttpFoundation\Response;
use UIoT\exceptions\InvalidRaiseResourceException;
use UIoT\view\RequestInput;

/**
 * Class RequestControl
 *
 * @package UIoT\control
 *
 * @property string[] $methods
 * @property string[] $resources
 */
final class RequestController
{
    /**
     * @var string[] Request methods(Get, Post, Put and Delete).
     */
    protected $methods = array('GET', 'POST', 'PUT', 'DELETE');

    /**
     * @var string[] Request resources.
     */
    protected $resources = array('slave_controllers', 'devices', 'services', 'actions', 'state_variables', 'resources');

    /**
     * Validate Request Data
     *
     * @param RequestInput $request
     *
     * @return RequestInput
     */
    public function createRequest(RequestInput $request)
    {
        $this->assignRequestCode($request);

        return $request;
    }

    /**
     * Assign Request Code
     *
     * @param RequestInput $request
     *
     * @return Response
     *
     * @throws InvalidRaiseResourceException
     */
    private function assignRequestCode(RequestInput $request)
    {
        //if (!$request->getRequestData()->getRequestValidation()->isValidRequest($this))
            //throw new InvalidRaiseResourceException;
    }

    /**
     * Return Available Methods
     *
     * @return string[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Return Available Resources
     *
     * @return string[]
     */
    public function getResources()
    {
        return $this->resources;
    }
}
