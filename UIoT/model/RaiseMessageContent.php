<?php

namespace UIoT\model;

use stdClass;
use UIoT\interfaces\RaiseMessageContent as RaiseMessageContentInterface;

/**
 * Class RaiseMessageContent
 * @package UIoT\model
 */
class RaiseMessageContent implements RaiseMessageContentInterface
{
    /**
     * @var stdClass of content sets
     */
    protected $content;

    /**
     * RaiseMessageContent constructor.
     */
    public function __construct()
    {
        $this->content = new stdClass;
    }

    /**
     * Add a content set
     *
     * @param string $name
     * @param mixed $content
     */
    public function addContent($name, $content)
    {
        $this->content->{$name} = $content;
    }

    /**
     * Generates content array
     *
     * @return stdClass
     */
    public function getContent()
    {
        return $this->content;
    }
}
