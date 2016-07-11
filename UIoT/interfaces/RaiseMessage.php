<?php

namespace UIoT\interfaces;

/**
 * Class RaiseException
 * @package UIoT\interfaces
 */
interface RaiseMessage
{
    /**
     * Generates and returns Json
     *
     * @return string
     */
    public function getResult();
}
