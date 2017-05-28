<?php

namespace App\Managers;

use App\Facades\JsonFacade;
use App\Models\Response\DataResponse;
use App\Models\Response\MessageResponse;

/**
 * Class ResponseManager.
 */
class ResponseManager
{
    /**
     * Response Manager Instance.
     *
     * @var ResponseManager|null
     */
    private static $instance = null;
    /**
     * Response Model.
     *
     * @var MessageResponse|DataResponse
     */
    private $responseModel = null;

    /**
     * Create a ResponseManager Instance.
     *
     * @param null|string $contentType
     */
    public function __construct($contentType = null)
    {
        self::$instance = $this;

        if ($contentType !== null) {
            $this->addHeader('Content-Type', $contentType);
        }
    }

    /**
     * Add a Header to the Response.
     *
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    public function addHeader(string $name, string $value)
    {
        header("{$name}: {$value}");
    }

    /**
     * Get Response Manager Instance.
     *
     * @return ResponseManager|null
     */
    public static function get()
    {
        return self::$instance;
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
        if ($this->responseModel == null) {
            $this->setResponse(404);
        }

        return $callback($this->responseModel);
    }

    /**
     * Set the Response Content.
     *
     * @param int   $httpCode
     * @param mixed $description
     * @param bool  $returnContent
     *
     * @return MessageResponse|null
     */
    public function setResponse(int $httpCode, $description = null, bool $returnContent = false)
    {
        $this->setResponseModel($httpCode, new MessageResponse(),
            DatabaseManager::getConnection()->selectById('metadata', $httpCode));

        $this->responseModel->details = $description;

        return $returnContent ? $this->responseModel : null;
    }

    /**
     * Set the Response Data.
     *
     * @param int           $httpCode
     * @param string|object $model
     * @param array|object  $data
     */
    public function setResponseModel(int $httpCode, $model, $data)
    {
        $this->setCode($httpCode);

        $this->responseModel = JsonFacade::map($model, $data);

        $this->responseModel->codHttp = $httpCode;
    }

    /**
     * Set HTTP Response Code.
     *
     * @param int $code
     */
    public function setCode(int $code)
    {
        http_response_code($code);
    }

    /**
     * Set the Data of a DataModel.
     *
     * @param int   $httpCode
     * @param array $values
     * @param bool  $returnContent
     *
     * @return DataResponse|MessageResponse|null
     */
    public function setResponseData(int $httpCode, array $values, bool $returnContent = false)
    {
        $this->setResponseModel($httpCode, new DataResponse(), ['values' => $values]);

        return $returnContent ? $this->responseModel : null;
    }
}
