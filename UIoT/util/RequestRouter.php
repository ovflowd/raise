<?php

namespace UIoT\util;

use UIoT\control\ResourceController;
use UIoT\view\RequestInput;

/**
 * Class RequestRouter
 *
 * @package UIoT\util
 * @property ResourceController $resourceController
 */
class RequestRouter
{
    /**
     * @var ResourceController
     */
    var $resourceController;

    /**
     * RequestRouter constructor.
     */
    public function __construct()
    {
        self::createResourceController();
    }

    /**
     * Creates a new ResourceController object | @see ResourceController.php
     */
    private function createResourceController()
    {
        $this->resourceController = new ResourceController();
    }

    /**
     * Executes the received Request | @see Request.php
     *
     * @param RequestInput $request
     * @return array|bool|string
     */
    public function submitRequest(RequestInput $request)
    {
        return self::getResourceController()->executeRequest($request);
    }

    /**
     * Returns the resource controller attribute | @see $resourceController
     *
     * @return ResourceController
     */
    public function getResourceController()
    {
        return $this->resourceController;
    }
}