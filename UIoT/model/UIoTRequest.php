<?php

namespace UIoT\model;

use Purl\Url;
use Symfony\Component\HttpFoundation\Request;
use UIoT\messages\WelcomeToRaiseMessage;
use UIoT\util\MessageHandler;

/**
 * Class UIoTRequest
 * @package UIoT\model
 */
class UIoTRequest extends Request
{
    /**
     * @var Url Raise Request
     */
    protected $requestUriData;

    /**
     * Gets the resource attribute. | @see $resource
     *
     * @return string
     */
    public function getResource()
    {
        if (null === $this->requestUriData) {
            return '';
        }

        return $this->getUri()->getPath()->getData()[1];
    }

    /**
     *
     */
    public function getParameterColumns()
    {
        $columnNames = array();

        $parameters = explode("&", explode("?", $this->getRequestUri())[1]);
        foreach ($parameters as $parameter) {
            $columnNames[] = explode("=", $parameter)[0];
        }

        return $columnNames;
    }

    /**
     * Assign Request Data
     */
    public function assignRequest()
    {
        if (null === $this->requestUriData) {
            $this->setUri();
        }
    }

    /**
     * Set Request Uri Data
     */
    public function setUri()
    {
        $this->requestUriData = new Url($base = '/' . basename($this->getRequestUri()));

        if ($base == '/') {
            MessageHandler::getInstance()->endExecution(new WelcomeToRaiseMessage);
        }
    }

    /**
     * Get Request URI Data
     *
     * @return Url
     */
    public function getUri()
    {
        return $this->requestUriData;
    }
}
