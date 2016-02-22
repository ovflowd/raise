<?php

namespace UIoT\model;

use Purl\Url;
use Symfony\Component\HttpFoundation\Request;
use UIoT\exceptions\InvalidUrlArgumentException;
use UIoT\util\RequestValidation;

/**
 * Class UIoTRequest
 *
 * @package UIoT\model
 */
class UIoTRequest extends Request
{
    /**
     * Validate Request
     *
     * @var RequestValidation
     */
    protected $requestValidation;

    /**
     * @var Url
     */
    protected $requestUriData;

    /**
     * Gets the resource attribute. | @see $resource
     *
     * @return string
     */
    public function getResource()
    {
        if (null === $this->requestUriData)
            return '';

        return $this->getRequestUriData()->getPath()->getData()[1];
    }

    /**
     * Return Request Validation Class
     *
     * @return RequestValidation
     */
    public function getRequestValidation()
    {
        return $this->requestValidation;
    }

    /**
     * Set Request Validation
     */
    public function setRequestValidation()
    {
        $this->requestValidation = new RequestValidation($this);
    }

    /**
     * Assign Request Data
     */
    public function assignRequestData()
    {
        if (null === $this->requestUriData)
            $this->setRequestUriData();
    }

    /**
     * Set Request Uri Data
     */
    public function setRequestUriData()
    {
        if ($this->getRequestUri() == '/')
            throw new InvalidUrlArgumentException;

        $this->requestUriData = new Url($this->getRequestUri());
    }

    /**
     * Get Request URI Data
     *
     * @return Url
     */
    public function getRequestUriData()
    {
        return $this->requestUriData;
    }
}
