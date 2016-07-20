<?php

/**
 * UIoT Service Layer
 * @version alpha
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
     * Instantiate the Symfony HTTP Request Interface
     * by Apache's (or used web server) globals parameters
     *
     * The parameters are populated by PHP's $_SERVER
     */
    public function __construct()
    {
        $this->httpRequest = Request::createFromGlobals();

        /* check if RAISe is being executed in Document Root, if not terminate execution. */
        if (!empty($this->getRequest()->getBasePath())) {
            die('<h2>RAISe need to be executed in your server\'s Document Root</h2>
                    This happens because <b>RAISe</b> is an Application Service Server');
        }
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
     * Return the Requested RAISe Resource Friendly Name
     * Getting it by the HTTP Request
     *
     * @return string RAISe Resource Name
     */
    public function getResource()
    {
        $resourceString = str_replace('/', '', $this->getRequest()->getRequestUri());
        
        return strpos($resourceString, '?') !== false ? strstr($resourceString, '?', true) : $resourceString;
    }
}
