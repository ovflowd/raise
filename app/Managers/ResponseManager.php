<?php

namespace App\Managers;

use App\Models\Response\ResponseModel;

/**
 * Class ResponseManager.
 */
class ResponseManager
{
    /**
     * Response Model.
     *
     * @var ResponseModel
     */
    private $responseModel = null;

    /**
     * Create a ResponseManager Instance.
     *
     * @param null|string $contentType
     */
    public function __construct($contentType = null)
    {
        if ($contentType !== null) {
            $this->addHeader('Content-Type', $contentType);
        }

        $this->responseModel = new ResponseModel();
    }

    /**
     * Add a Header to the Response.
     *
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    public function addHeader(String $name, String $value)
    {
        header("{$name}: {$value}");
    }

    /**
     * Set the Response Content.
     *
     * @param int $httpCode
     * @param $description
     */
    public function setResponse(Int $httpCode, $description)
    {
        $responseData = DatabaseManager::getConnection()->select('metadata', ['codHttp' => $httpCode]);

        foreach ($responseData as $property => $value) {
            if (property_exists($this->responseModel, $property)) {
                $this->responseModel->{$property} = $value;
            }
        }

        $this->responseModel->description = $description;
    }

    /**
     * Get the Response Content.
     *
     * @param null|callable $callback
     *
     * @return string
     */
    public function getResponse($callback = null)
    {
        return $callback($this->responseModel);
    }
}
