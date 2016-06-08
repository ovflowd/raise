<?php

namespace UIoT\util;

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
     * RaiseStatus Constructor
     *
     * @param int $code
     * @param string $message
     */
    public function __construct($code = 200, $message = 'No Message')
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Return RaiseStatus
     *
     * @return array
     */
    public function getStatus()
    {
        return get_object_vars($this);
    }
}
