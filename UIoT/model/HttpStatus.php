<?php

namespace UIoT\model;

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
    public function __construct($code, $message)
    {
        self::setCode($code);
        self::setMessage($message);
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
     */
    public function setMessage($message)
    {
        if (is_null($message))
            self::setDefaultMessage();
        else
            $this->message = $message;
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
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Sets the message attribute based on the code attribute | @see $message, $code
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
                self::setMessage("");
                break;
        }
    }
}