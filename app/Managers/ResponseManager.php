<?php

namespace App\Managers;

use App\Models\Communication\Model;
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
     * @param string $httpCode
     * @param mixed $description
     * @param bool $returnContent
     *
     * @return MessageResponse|null
     */
    public function setResponse(string $httpCode, $description = null, bool $returnContent = false)
    {
        $this->setCode($httpCode);

        $this->responseModel = new MessageResponse();

        $responseData = array_merge(DatabaseManager::getConnection()->select('metadata',
            [['codHttp', $httpCode, '=']])[0]->metadata, array('details' => $description));

        $this->responseModel->fill($responseData);

        return $returnContent ? $this->responseModel : null;
    }

    /**
     * Set the Data of a DataModel
     *
     * @param string $httpCode
     * @param array $values
     * @param bool $returnContent
     * @return DataResponse|MessageResponse|null
     */
    public function setData(string $httpCode, array $values, bool $returnContent = false)
    {
        $this->setCode($httpCode);

        $this->responseModel = new DataResponse();

        $this->responseModel->values = $values;

        return $returnContent ? $this->responseModel : null;
    }

    /**
     * Set a Custom Model with Data
     *
     * @param string $httpCode
     * @param Model $responseModel
     * @param bool $returnContent
     * @return Model|DataResponse|MessageResponse|null
     */
    public function setModel(string $httpCode, Model $responseModel, bool $returnContent = false)
    {
        $this->setCode($httpCode);

        $this->responseModel = $responseModel;

        return $returnContent ? $this->responseModel : null;
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
}
