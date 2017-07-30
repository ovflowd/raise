<?php

/**
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

namespace App\Facades;

use App\Models\Communication\Model;
use App\Models\Response\Client;
use App\Models\Response\Message;

/**
 * Class Response.
 *
 * A Facade that manages and handles
 * everything related with the output content of
 * the execution of RAISe
 *
 * @see https://en.wikipedia.org/wiki/Facade_pattern Documentation of the Pattern
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Response extends Facade
{
    /**
     * Response Model.
     *
     * The Model that will be sent on the execution output
     *
     * @var Message|Client
     */
    private static $response;

    /**
     * Response Content Type.
     *
     * @var string
     */
    private static $type = 'application/json';

    /**
     * Prepare ResponseFacade.
     *
     * This method does some pre-configurations
     * to prepare the ResponseFacade
     *
     * @see https://www.w3.org/Protocols/rfc1341/4_Content-Type.html RFC1341
     *
     * @param string $contentType The content type of RAISe
     *
     * @return Facade|Response|string Return the static instance of the Facade
     */
    public static function prepare(string $contentType = null)
    {
        if ($contentType !== null) {
            self::$type = $contentType;
        }

        // Reset the Response Model
        self::$response = null;

        return self::get();
    }

    /**
     * Set manually a override of the content type.
     *
     * @param string $contentType The given content type
     *
     * @return string The actual Content Type
     */
    public static function type(string $contentType = null)
    {
        if ($contentType !== null) {
            self::$type = $contentType;
        }

        return self::$type;
    }

    /**
     * Add a HTTP Header to the Response.
     *
     * @see https://en.wikipedia.org/wiki/List_of_HTTP_header_fields List of Headers
     *
     * @param string $name Desired HTTP Headers
     * @param string $value the value of the Header
     *
     * @return void
     */
    public static function header(string $name, string $value)
    {
        header("{$name}: {$value}");
    }

    /**
     * Get the Response Content, and if a callable be applied
     * call the callback and return it contents.
     *
     * @param callable|null $callback an optional callback for result
     *
     * @return string|object|array|Model the result of the callback
     */
    public static function response($callback = null)
    {
        self::header('Content-Type', self::$type);

        if (self::$response == null) {
            self::message(404);
        }

        if (is_callable($callback)) {
            return $callback(self::$response);
        }

        return self::$response;
    }

    /**
     * Set the Response Content.
     *
     * Set a Response Content using the Default Response Model, the MessageResponse
     *
     * @see Message used Model
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Codes
     *
     * @param int $httpCode desired HTTP Code
     * @param string $details Response Details
     * @param bool $returnContent If need return the content
     *
     * @return Message|null The returned content or nothing
     */
    public static function message(int $httpCode, string $details = null, bool $returnContent = false)
    {
        self::setResponse($httpCode, new Message(), (array)database()->selectById('metadata', $httpCode)
            + ['details' => $details]);

        return $returnContent ? self::$response : null;
    }

    /**
     * Set a specific ResponseModel.
     *
     * @see Model base of the Models
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Codes
     *
     * @param int $httpCode desired HTTP code
     * @param string|Model $model the namespace of the model or an instance of it
     * @param array|object $data the data to be mapped into the Model
     */
    public static function setResponse(int $httpCode, $model, $data)
    {
        self::code($httpCode);

        self::$response = json()::map($model, (array)database()->selectById('metadata', $httpCode) + $data);
    }

    /**
     * Set the HTML Content for the Response.
     *
     * @param string $content the HTML Content
     */
    public static function setContent(string $content)
    {
        if (null === self::$response || !is_string(self::$response)) {
            self::$response = '';
        }

        self::$response .= $content;
    }

    /**
     * Set HTTP Response Code.
     *
     * @see http_response_code()
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html HTTP Codes
     *
     * @param int $code
     */
    public static function code(int $code)
    {
        http_response_code($code);
    }
}
