<?php

namespace App\Managers;

use App\Models\Response\ResponseModel;

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
        self::$instance = $this;

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
        if ($this->responseModel->codHttp == null) {
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
     * @return ResponseModel|null
     */
    public function setResponse(string $httpCode, $description = null, bool $returnContent = false)
    {
        $this->setCode($httpCode);

        $responseData = DatabaseManager::getConnection()->select('metadata',
            [['codHttp', $httpCode, '=']])[0]->metadata;

        $this->responseModel->fill($responseData);

        $this->responseModel->description = $description;

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
