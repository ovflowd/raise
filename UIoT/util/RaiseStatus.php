<?php

namespace UIoT\util;

use stdClass;

/**
 * Class RaiseStatus
 * @package UIoT\util
 */
class RaiseStatus
{
    /**
     * @var int Raise Status Code
     */
    private $code;

    /**
     * @var string Raise Status Message
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

    /**
     * Get Raise Status
     *
     * @return stdClass
     */
    public function getStatus()
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
     * @return RaiseStatus
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
     * @return RaiseStatus
     */
    public function setMessage($message = '')
    {
        $this->message = $message;

        return $this;
    }
}