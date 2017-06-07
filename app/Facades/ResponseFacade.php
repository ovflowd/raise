<?php

namespace App\Facades;

use App\Models\Response\ClientListResponse;
use App\Models\Response\MessageResponse;

/**
 * Class ResponseFacade.
 */
class ResponseFacade extends Facade
{
    /**
     * Response Model.
     *
     * @var MessageResponse|ClientListResponse
     */
    private static $responseModel = null;

    /**
     * Prepare ResponseFacade.
     *
     * @param string $contentType
     *
     * @return ResponseFacade
     */
    public static function prepare(string $contentType = null)
    {
        if ($contentType !== null) {
            self::addHeader('Content-Type', $contentType);
        }

        return self::get();
    }

    /**
     * Add a Header to the Response.
     *
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    public static function addHeader(string $name, string $value)
    {
        header("{$name}: {$value}");
    }

    /**
     * Get the Response Content.
     *
     * @param null|callable $callback
     *
     * @return string
     */
    public static function getResponse($callback = null)
    {
        if (self::$responseModel == null) {
            self::setResponse(404);
        }

        return $callback(self::$responseModel);
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
    public static function setResponse(int $httpCode, $description = null, bool $returnContent = false)
    {
        self::setResponseModel($httpCode, new MessageResponse(), database()->selectById('metadata', $httpCode));

        self::$responseModel->details = $description;

        return $returnContent ? self::$responseModel : null;
    }

    /**
     * Set the Response Data.
     *
     * @param int           $httpCode
     * @param string|object $model
     * @param array|object  $data
     */
    public static function setResponseModel(int $httpCode, $model, $data)
    {
        self::setCode($httpCode);

        self::$responseModel = JsonFacade::map($model, $data);

        self::$responseModel->codHttp = $httpCode;
    }

    /**
     * Set HTTP Response Code.
     *
     * @param int $code
     */
    public static function setCode(int $code)
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
     * @return ClientListResponse|MessageResponse|null
     */
    public static function setResponseData(int $httpCode, array $values, bool $returnContent = false)
    {
        self::setResponseModel($httpCode, new ClientListResponse(), ['values' => $values]);

        return $returnContent ? self::$responseModel : null;
    }
}
