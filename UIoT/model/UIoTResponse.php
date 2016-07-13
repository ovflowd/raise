<?php

namespace UIoT\model;

use Symfony\Component\HttpFoundation\Response;
use UIoT\util\RequestInput;

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
     * Create a New UIoT Response
     *
     * @param mixed|string $content
     * @param int $status
     * @param array $headers
     */
    public function __construct($content = '', $status = 200, array $headers = [])
    {
        parent::__construct($content, $status, $headers);

        $this->prepare(RequestInput::getRequest());
    }

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