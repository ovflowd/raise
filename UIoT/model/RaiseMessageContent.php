<?php

namespace UIoT\model;

use UIoT\interfaces\RaiseMessageContent as RaiseMessageContentInterface;

/**
 * Class RaiseMessageContent
 * @package UIoT\model
 */
class RaiseMessageContent implements RaiseMessageContentInterface
{
    /**
     * @var array of content sets
     */
    protected $content = array();

    /**
     * Add a content set
     *
     * @param string $name
     * @param mixed $content
     */
    public function addContent($name, $content)
    {
        array_push($this->content, array($name => $content));
    }

    /**
     * Generates content array
     *
     * @return array
     */
    public function getContentArray()
    {
        return $this->content;
    }
}
