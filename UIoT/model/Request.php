<?php

namespace UIoT\model;

/**
 * Class Request
 *
 * @package UIoT\model
 * @property string $uri
 * @property string $resource
 * @property string[] $parameters
 * @property string $method
 * @property string $protocol
 * @property string[] $scriptName
 * @property string $errorStatus
 */
class Request
{
    /**
     * @var string Uniform Resource Identifier.
     */
    private $uri;

    /**
     * @var string Resource to be requested (actions, services, devices,etc).
     */
    private $resource;

    /**
     * @var string[] Parameters of the request.
     */
    private $parameters;

    /**
     * @var string Request method(Get, Post, Put or Delete).
     */
    private $method;

    /**
     * @var string Communication protocol (HTTP OR HTTPS)
     */
    private $protocol;

    /**
     * @var string[] Name of the script used on the request.
     */
    private $scriptName;

    /**
     * @var string HTTP/HTTPS error (See List of HTTP status codes for reference)
     */
    private $errorStatus;


    /**
     * Request constructor.
     *
     * @param string $uri
     * @param string $method
     * @param string $protocol
     * @param string[] $scriptName
     */
    public function __construct($uri, $method, $protocol, $scriptName)
    {
        self::setMethod($method);
        self::setScriptName($scriptName);
        self::setProtocol($protocol);
        self::setUri(self::prepareUri($uri));
        self::setResource();
        self::setParameters($uri);
    }

    /**
     * Set method attribute. | @see $method
     *
     * @param string $method
     */
    private function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Set scriptName attribute. | @see $scriptName
     *
     * @param string[] $scriptName
     */
    private function setScriptName($scriptName)
    {
        $this->scriptName = $scriptName;
    }

    /**
     * Set protocol attribute. | @see $protocol
     *
     * @param string $protocol
     */
    private function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * Set uri attribute. | @see $uri
     *
     * @param string $uri
     */
    private function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Prepares a uri by removing unnecessary parts.
     *
     * @param string $rawUri
     * @return string[]
     */
    private function prepareUri($rawUri)
    {
        return self::removeUriParameters(self::removeScriptParameters($rawUri));
    }

    /**
     * Removes a uri's parameters.
     *
     * @param string $uri
     * @return string[]
     */
    private function removeUriParameters($uri)
    {
        $uriArray = explode('?', end($uri));
        $lastUriElement = reset($uriArray);
        end($uri);
        $uri[key($uri)] = $lastUriElement;
        return $uri;
    }

    /**
     * Removes a uri's script parameters.
     *
     * @param string $uri
     * @return string[]
     */
    private function removeScriptParameters($uri)
    {
        $script_size = sizeof($this->scriptName);
        for ($i = 0; $i < $script_size; $i++) {
            if ($uri[$i] == $this->scriptName[$i]) {
                unset($uri[$i]);

            }
        }
        return array_filter(array_values($uri));
    }

    /**
     * Set the resource attribute based on the uri attribute.
     */
    private function setResource()
    {
        if (empty(array_filter(self::getUri())))
            $this->resource = NULL;
        else
            $this->resource = self::getUri()[0];
    }

    /**
     * Gets the uri attribute. | @see $uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Sets the parameters attribute using a uri. | @see $parameters
     *
     * @param string $uri
     */
    private function setParameters($uri)
    {
        $this->parameters = self::setParametersMap($uri);
    }

    /**
     * Sets a parameter's map using a uri.
     *
     * @param string $uri
     * @return string[]|null
     */
    private function setParametersMap($uri)
    {
        $stringParameters = self::getUriParametersAsString(end($uri));

        if ($stringParameters !== "")
            return self::getUriParametersAsArray($stringParameters);

        return NULL;
    }

    /**
     * Gets a uri's parameters as a string.
     *
     * @param string $rawStringParameters
     * @return string[]
     */
    private function getUriParametersAsString($rawStringParameters)
    {
        if (!strpos($rawStringParameters, '?') === 0 || strpos($rawStringParameters, '?') === FALSE) {
            return "";
        }
        $parametersArray = explode('?', $rawStringParameters);
        return end($parametersArray);
    }

    /**
     * Gets a uri's parameters as an array.
     *
     * @param string $stringParameters
     * @return string[]
     */
    private function getUriParametersAsArray($stringParameters)
    {
        $parameters = array();
        $tmpArray = explode('&', $stringParameters);

        foreach ($tmpArray as $parameter) {
            $keyValueParameter = explode("=", $parameter);
            $parameters[$keyValueParameter[0]] = $keyValueParameter[1];
        }

        return $parameters;
    }

    /**
     * Gets the resource attribute. | @see $resource
     *
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Gets the method attribute. | @see $method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Gets the protocol attribute. | @see $protocol
     *
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * Gets the scriptName attribute. | @see $scriptName
     *
     * @return string
     */
    public function getScriptName()
    {
        return $this->scriptName;
    }

    /**
     * Returns whether or not parameters exist.
     *
     * @return bool
     */
    public function hasParameters()
    {
        return !(self::getParameters() == NULL);
    }

    /**
     * Gets the parameters attribute. | @see $parameters
     *
     * @return string[]|null
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Gets the errorStatus attribute. | @see $errorStatus
     *
     * @return string|null
     */
    public function getErrorStatus()
    {
        return $this->errorStatus;
    }

    /**
     * Sets the errorStatus attribute. | @see $errorStatus
     *
     * @param string $httpStatus
     */
    public function setErrorStatus($httpStatus)
    {
        $this->errorStatus = $httpStatus;
    }

    /**
     * Returns whether or not the uri attribute is composed.
     *
     * @return bool
     */
    public function hasComposedUri()
    {
        return sizeof(self::getUri()) > 1;
    }
}
