<?php

namespace UIoT\interfaces;

/**
 * Class RaiseException
 * @package UIoT\interfaces
 */
interface RaiseMessage
{
    /**
     * Gets message Code
     *
     * @return integer
     */
    public function getCode();

    /**
     * Gets message content
     *
     * @return array
     */
    public function getMessage();

    /**
     * Generates and returns Json
     *
     * @return string
     */
    public function generateJson();
}
