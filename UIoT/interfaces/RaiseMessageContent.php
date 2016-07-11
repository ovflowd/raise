<?php

namespace UIoT\interfaces;

/**
 * Interface RaiseMessageContent
 * @package UIoT\interfaces
 */
interface RaiseMessageContent
{
    /**
     * Add a content set
     *
     * @param string $name
     * @param mixed $content
     */
    public function addContent($name, $content);

    /**
     * Generates content array
     *
     * @return array
     */
    public function getContentArray();

}
