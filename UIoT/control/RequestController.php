<?php

namespace UIoT\control;

use UIoT\database\DatabaseExecuter;
use UIoT\model\UIoTRequest;
use UIoT\util\ExceptionHandler;
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
    protected $resources = array();

    private $dbExecuter;

    public function __construct($dbExecuter)
    {
        $this->dbExecuter = $dbExecuter;
    }

    /**
     * Executes a request.
     *
     * @param RequestInput $request
     * @return bool|string[]
     */
    public function createRequest(RequestInput $request)
    {
        if (ExceptionHandler::getInstance()->getRaiseMessage() !== null)
            return ExceptionHandler::getInstance()->show();

        return $request->getRequestData();
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
