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
     * Status Text
     *
     * @var string
     */
    protected $statusText;

    /**
     * Get Status Text
     *
     * @return mixed
     */
    public function getStatusText()
    {
        return $this->statusText;
    }
}