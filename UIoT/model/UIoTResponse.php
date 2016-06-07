<?php

namespace UIoT\model;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class UIoTResponse
 * @package UIoT\model
 */
class UIoTResponse extends Response
{
    /**
     * @var string Status Text
     */
    protected $statusText;

    /**
     * Return Status Text
     *
     * @return mixed
     */
    public function getStatusText()
    {
        return $this->statusText;
    }
}