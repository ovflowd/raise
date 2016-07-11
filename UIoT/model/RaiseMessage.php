<?php

namespace UIoT\model;

use UIoT\interfaces\RaiseMessage as RaiseMessageInterface;

/**
 * Class RaiseMessage
 * @package UIoT\model
 */
class RaiseMessage implements RaiseMessageInterface
{
    /**
     * @var int Message Code
     */
    protected $code = 200;

    /**
     * @var RaiseMessageContent
     */
    protected $content;

    /**
     * RaiseMessage constructor.
     *
     * @param integer $code
     * @param RaiseMessageContent $content
     */
    public function __construct($code, RaiseMessageContent $content)
    {
        $this->code = $code;
        $this->content = $content;
    }

    /**
     * Gets message Code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Gets message content
     *
     * @return array
     */
    public function getMessage()
    {
        return $this->content;
    }

    /**
     * Generates and returns Json
     *
     * @return string
     */
    public function generateJson()
    {
        return json_encode(array('code' => $this->code, $this->content->getContentArray()));
    }
}
