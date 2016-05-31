<?php

namespace UIoT\model;

use stdClass;

/**
 * Class HTTPStatus
 *
 * @package UIoT\model
 * @property int $code
 * @property string $message
 */
class HTTPStatus
{
    /**
     * @var int HTTP error number/code.
     */
    private $code;

    /**
     * @var string HTTP error message.
     */
    private $message;

    /**
     * HTTPStatus constructor.
     *
     * @param int $code
     * @param string $message
     */
    public function __construct($code = 200, $message = '')
    {
        self::setCode($code);

        self::setMessage($message);
    }

    public function returnStatus()
    {
        $responseCodes = new stdClass();
        $responseCodes->code = $this->getCode();
        $responseCodes->message = $this->getMessage();

        return $responseCodes;
    }

    /**
     * Gets the code attribute. | @see $code
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the code attribute. | @see $code
     *
     * @param int $code
     *
     * @return HTTPStatus
     */
    public function setCode($code = 200)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Gets the message attribute. | @see $message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the message attribute. | @see $message
     *
     * @param string $message
     *
     * @return HTTPStatus
     */
    public function setMessage($message = '')
    {
        if (empty($message))
            self::setDefaultMessage();
        else
            $this->message = $message;

        return $this;
    }

    /**
     * Sets the message attribute based on the code attribute | @see $message, $code
     *
     * @return HTTPStatus
     */
    private function setDefaultMessage()
    {
        switch (self::getCode()) {
            case 400:
                $this->message = "Bad request";
                break;

            case 403:
                $this->message = "Forbidden";
                break;

            case 404:
                $this->message = "Resource not found";
                break;

            case 405:
                $this->message = "Method not allowed";
                break;

            default:
                $this->message = "";
                break;
        }

        return $this;
    }
}