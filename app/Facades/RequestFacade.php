<?php

namespace App\Facades;

/**
 * Class RequestFacade.
 */
class RequestFacade
{
    /**
     * Requested Page Sent Headers.
     *
     * @var array
     */
    private static $headers = [];

    /**
     * Requested Page Method (GET, POST, PUT, DELETE, OPTIONS).
     *
     * @var string
     */
    private static $method = 'GET';

    /**
     * Requested Page Body (POST, PUT).
     *
     * @var object
     */
    private static $body = null;

    /**
     * Requested Page Query String.
     *
     * @var array
     */
    private static $query = [];

    /**
     * Get the RequestFacade Instance
     *
     * @return self
     */
    public static function get()
    {
        return __CLASS__;
    }

    /**
     * Prepare the RequestFacade with the Requested Page Data.
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
     * @param string|null $key
     *
     * @return array|bool
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
     * @param string|null $key
     *
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
     * Return the Query String or a Parameter from the Query String if exists.
     *
     * Note.: Return false if doesn't exists
     *
     * @param string|null $key
     *
     * @return array|bool
     */
    public static function query(string $key = null)
    {
        if ($key == null) {
            return self::$query;
        }

        return array_key_exists($key, self::$query) ? self::$query[$key] : false;
    }
}
