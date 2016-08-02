<?php

/**
 * UIoT Service Layer
 * @version beta
 *                          88
 *                          ""              ,d
 *                                          88
 *              88       88 88  ,adPPYba, MM88MMM
 *              88       88 88 a8"     "8a  88
 *              88       88 88 8b       d8  88
 *              "8a,   ,a88 88 "8a,   ,a8"  88,
 *               `"YbbdP'Y8 88  `"YbbdP"'   "Y888
 *
 * @author Universal Internet of Things
 * @license MIT <https://opensource.org/licenses/MIT>
 * @copyright University of Brasília
 */

namespace UIoT\Handlers;

use Symfony\Component\HttpFoundation\Request;
use UIoT\Managers\RaiseManager;
use UIoT\Models\ResourceModel;

/**
 * Class RequestHandler
 * @package UIoT\Handlers
 */
class RequestHandler
{
    /**
     * HTTP Request Interface
     *
     * @var Request
     */
    private $httpRequest;

    /**
     * RAISe Requested Resource
     *
     * @var ResourceModel
     */
    private $requestedResource;

    /**
     * Instantiate the Symfony HTTP Request Interface
     * by Apache's (or used web server) globals parameters
     *
     * The parameters are populated by PHP's $_SERVER
     */
    public function __construct()
    {
        /* set the Symfony's HTTP Request */
        $this->httpRequest = Request::createFromGlobals();

        /* check if RAISe is being executed in Document Root, if not terminate execution. */
        if (!empty($this->getRequest()->getBasePath())) {
            die('<h2>RAISe need to be executed in your server\'s Document Root</h2>');
        }

        $this->setResource();
    }

    /**
     * Return the HTTP Request Interface
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->httpRequest;
    }

    /**
     * Set RAISe Requested Resource
     * Resource Model by the HTTP Request Requested Uri
     *
     * @note A string manipulation is applied since php's
     * function strstr will return null if the desired match
     * isn't present.
     */
    public function setResource()
    {
        /* get resource string from requested url */
        $resourceString = strtolower(str_replace('/', '', $this->getRequest()->getRequestUri()));

        /* stores resource model applying the string manipulation */
        $this->requestedResource = RaiseManager::getFactory('resource')->get(strpos($resourceString,
            '?') !== false ? strstr($resourceString, '?', true) : $resourceString);
    }

    /**
     * this method checks if the Request contains in his
     * Query String invalid parameters for the Requested Resource
     * parameters are the Properties from a Resource.
     *
     * Return the invalid argument (parameter) if exists
     * if not return true
     *
     * @return string|bool
     */
    public function checkInvalidParameters()
    {
        $invalid = array_diff_key(array_diff_key($this->getRequest()->query->all(),
            $this->getResource()->getProperties()->getAll()), ['token' => '']);

        return !empty($invalid) ? reset(array_keys($invalid)) : true;
    }

    /**
     * Get RAISe Requested Resource
     *
     * @note only one Resource can be requested
     * by a single HTTP Request. The Requested
     * resource is the Resource that will be used
     * during the instance of this Request
     *
     * @return ResourceModel
     */
    public function getResource()
    {
        return $this->requestedResource;
    }
}
