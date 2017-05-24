<?php

namespace App\Facades;

use stdClass;

/**
 * Class RequestFacade.
 */
class RequestFacade
{
    /**
     * Requested Page Sent Headers
     *
     * @var array
     */
    private static $headers = [];

    /**
     * Requested Page Method (GET, POST, PUT, DELETE, OPTIONS)
     *
     * @var string
     */
    private static $method = 'GET';

    /**
     * Requested Page Body (POST, PUT)
     *
     * @var object
     */
    private static $body = null;

    /**
     * Requested Page Query String
     *
     * @var array
     */
    private static $query = [];

    /**
     * Prepare the RequestFacade with the Requested Page Data
     *
     * @param array $headers
     * @param string $method
     * @param array $server
     */
    public static function prepare(array $headers, string $method, array $server)
    {
        self::$headers = $headers;

        self::$method = $method;

        parse_str(parse_url($server['REQUEST_URI'], PHP_URL_QUERY), $queryArray);

        self::$query = $queryArray;

        self::$body = JsonFacade::decode(file_get_contents('php://input') ?? new stdClass);
    }

    /**
     * Return Requested Page Method
     *
     * @return string
     */
    public static function method()
    {
        return self::$method;
    }

    /**
     * Return Requested Page Sent Headers
     *
     * @return array
     */
    public static function headers()
    {
        return self::$headers;
    }

    /**
     * Return the Requested Body or a Parameter of the Body
     *
     * Note.: Always an Object
     * Note.: Return false if doesn't exists
     *
     * @param string|null $key
     * @return object|bool
     */
    public static function body(string $key = null)
    {
        if ($key == null) {
            return self::$body;
        }

        return property_exists(self::$body, $key) ? self::$body->{$key} : false;
    }

    /**
     * Return the Query String or a Parameter from the Query String if exists
     *
     * Note.: Return false if doesn't exists
     *
     * @param string|null $key
     * @return array|mixed
     */
    public static function query(string $key = null)
    {
        if ($key == null) {
            return self::$query;
        }

        return array_key_exists($key, self::$query) ? self::$query[$key] : false;
    }
}
