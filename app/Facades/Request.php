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

use Bramus\Router\Router;

/**
 * Class Request.
 *
 * A Facade used to Handle and map all the Request inputs
 * like Headers, Method and Payload, QueryString, etc.
 *
 * @see https://en.wikipedia.org/wiki/Facade_pattern Documentation of the Pattern
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Request extends Facade
{
    /**
     * Requested Page Sent Headers.
     *
     * @see https://en.wikipedia.org/wiki/List_of_HTTP_header_fields Available Headers
     * @see Router (used to gather headers)
     *
     * @var array of headers
     */
    private static $headers = [];

    /**
     * Requested Page Method (GET, POST, PUT, DELETE, OPTIONS).
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html HTTP Methods
     *
     * @var string the requested method
     */
    private static $method = 'GET';

    /**
     * Requested Page Body (POST, PUT).
     *
     * A Payload that was sent on the Request
     * On RAISe will be used as Registering of Data
     *
     * @var object
     */
    private static $body;

    /**
     * Requested Page Query String.
     *
     * @see https://en.wikipedia.org/wiki/Query_string Documentation of QS
     *
     * @var array
     */
    private static $query = [];

    /**
     * Prepare the RequestFacade with the Requested Page Data.
     *
     * @see https://secure.php.net/manual/en/reserved.variables.server.php $_SERVER Manual
     *
     * @param array  $headers Given Headers
     * @param string $method  Given Requested Method
     * @param array  $server  $_SERVER super Global
     */
    public static function prepare(array $headers, string $method, array $server)
    {
        self::$headers = $headers;

        self::$method = $method;

        parse_str(parse_url($server['REQUEST_URI'], PHP_URL_QUERY), $queryArray);

        self::$query = $queryArray;

        $phpInput = file_get_contents('php://input');

        self::$body = json()::jsonDecode(empty($phpInput) ? '{}' : $phpInput);
    }

    /**
     * Return Requested Page Method.
     *
     * @return string
     */
    public static function method()
    {
        return self::$method;
    }

    /**
     * Return Requested Page Sent Headers.
     *
     * @param string|null $key specify a header to be returned
     *
     * @return array|bool the entire set of headers or only a value of a specific header
     */
    public static function headers(string $key = null)
    {
        if ($key == null) {
            return self::$headers;
        }

        return array_key_exists($key, self::$headers) ? self::$headers[$key] : false;
    }

    /**
     * Return the Requested Body or a Parameter of the Body.
     *
     * Note.: Always an Object
     * Note.: Return false if doesn't exists
     *
     * @param string|null $key an property/value of the payload
     *
     * @return object|bool the entire payload or a value of it (if exists)
     */
    public static function body(string $key = null)
    {
        if ($key == null) {
            return self::$body;
        }

        return property_exists(self::$body, $key) ? self::$body->{$key} : false;
    }

    /**
     * Return the Query String or a Parameter from the Query String if exists.
     *
     * Note.: Return false if doesn't exists
     *
     * @param string|null $key a specific query string element
     *
     * @return array|bool the entire query string as array or a value of it (if exists)
     */
    public static function query(string $key = null)
    {
        if ($key == null) {
            return self::$query;
        }

        return array_key_exists($key, self::$query) ? self::$query[$key] : false;
    }
}
