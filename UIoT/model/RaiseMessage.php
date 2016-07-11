<?php

namespace UIoT\model;

use stdClass;
use UIoT\interfaces\RaiseMessage as RaiseMessageInterface;

/**
 * Class RaiseMessage
 * @package UIoT\model
 */
class RaiseMessage implements RaiseMessageInterface
{
    /**
     * @var RaiseMessageContent
     */
    protected $content;

    /**
     * RaiseMessage constructor.
     *
     * @param RaiseMessageContent $content
     */
    public function __construct(RaiseMessageContent $content)
    {
        $this->content = $content;
    }

    /**
     * Get Message Result Content
     *
     * @return stdClass
     */
    public function getResult()
    {
        return $this->content->getContent();
    }

    /**
     * Get Message Content
     *
     * @return RaiseMessageContent
     */
    public function getContent()
    {
        return $this->content;
    }
}
