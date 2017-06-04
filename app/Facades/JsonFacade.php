<?php

namespace App\Facades;

use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use JsonMapper;
use JsonMapper_Exception;
use UnexpectedValueException;

/**
 * Class JsonFacade.
 */
class JsonFacade
{
    /**
     * Get the JsonFacade Instance
     *
     * @return self
     */
    public static function get()
    {
        return __CLASS__;
    }

    /**
     * Encode Data into a jSON string.
     *
     * @param $data
     *
     * @return string
     */
    public static function jsonEncode($data)
    {
        return JWT::jsonEncode($data);
    }

    /**
     * Decode a jSON String into Object.
     *
     * @param string $json
     *
     * @return object
     */
    public static function jsonDecode(string $json)
    {
        return JWT::jsonDecode($json);
    }

    /**
     * Encode data unto JWT Algorithm.
     *
     * @param string $secret
     * @param $data
     *
     * @return string
     */
    public static function encode(string $secret, $data)
    {
        return JWT::encode($data, $secret);
    }

    /**
     * Decode an.
     *
     * @param string $secret
     * @param string $hash
     *
     * @return object|bool
     */
    public static function decode(string $secret, string $hash)
    {
        try {
            return JWT::decode($hash, $secret, ['HS256']);
        } catch (SignatureInvalidException $e) {
            return false;
        } catch (UnexpectedValueException $e) {
            return false;
        }
    }

    /**
     * Map an object into a Model.
     *
     * @param string|object $model
     * @param $data
     *
     * @return object
     */
    public static function map($model, $data)
    {
        return self::doMap($model, $data, false, false);
    }

    /**
     * Internal Mapping Class
     * Executes an Object Mapping.
     *
     * @param string|object $model
     * @param array|object $data
     * @param bool $mapArray
     * @param bool $evaluateInput
     *
     * @return bool|mixed|object
     */
    private static function doMap($model, $data, bool $mapArray = false, bool $evaluateInput = false)
    {
        $mapper = new JsonMapper();

        if ($evaluateInput) {
            $mapper->bExceptionOnUndefinedProperty = true;
            $mapper->bExceptionOnMissingData = true;
        }

        $model = is_object($model) ? $model : new $model();

        if (property_exists($model, 'serverTime')) {
            $model->serverTime = microtime(true);
        }

        try {
            return $mapArray ? $mapper->mapArray($data, [], $model) : $mapper->map((object)$data, $model);
        } catch (JsonMapper_Exception $e) {
            return false;
        }
    }

    /**
     * Map a set of Data into a specific Model type.
     *
     * @param string|object $model
     * @param array $data
     *
     * @return bool|mixed|object
     */
    public static function mapSet($model, array $data)
    {
        return self::doMap($model, $data, true, false);
    }

    /**
     * Compare an Object with a Model
     * If the validation passes it return the Mapped Object
     * In other case, return a false boolean.
     *
     * @param string|object $model
     * @param $data
     *
     * @return bool|object
     */
    public static function compare($model, $data)
    {
        return self::doMap($model, $data, false, true);
    }

    public static function compareSet($model, array $data)
    {
        return self::doMap($model, $data, true, true);
    }
}
