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
use App\Models\Communication\Raise as RaiseModel;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use JsonMapper;
use JsonMapper_Exception;
use UnexpectedValueException;

/**
 * Class Json.
 *
 * A Facade that handles and manages the mapping
 * of objects, data and arrays, and also the encoding of data
 * like as JWT encoding
 *
 * @see https://jwt.io/introduction/ JWT Docmentation
 * @see https://en.wikipedia.org/wiki/Facade_pattern Documentation of the Pattern
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Json extends Facade
{
    /**
     * Encode Data into a jSON string.
     *
     * @see json_encode() Base method of encoding
     *
     * @param object|array $data the data to be encoded
     *
     * @return string the encoded jSON string
     */
    public static function jsonEncode($data)
    {
        return JWT::jsonEncode($data);
    }

    /**
     * Decode a jSON String into Object.
     *
     * @see json_decode() Base method of decoding
     *
     * @param string $json the given jSON string
     *
     * @return object|array the decoded jSON string into object
     *                      or array of objects
     */
    public static function jsonDecode(string $json)
    {
        return JWT::jsonDecode($json);
    }

    /**
     * Encode data unto JWT Algorithm.
     *
     * @see https://github.com/firebase/php-jwt JWT Library
     *
     * @param string             $secret The defined secret key
     * @param array|object|Model $data   the Data to be encoded
     *
     * @return string the generated JWT hash
     */
    public static function encode(string $secret, $data)
    {
        return JWT::encode($data, $secret);
    }

    /**
     * Decode an JWT hash into an Object.
     *
     * @see https://github.com/firebase/php-jwt JWT Library
     *
     * @param string $secret the given secret key
     * @param string $hash   the given JWT hash
     *
     * @return object|array|Model|bool false if is invalid, the object if is valid
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
     * @param string|object      $model the Model or Namespace of the Model to be Mapped
     * @param array|object|Model $data  the Data to be mapped
     *
     * @return object|Model|RaiseModel the mapped object
     */
    public static function map($model, $data)
    {
        return self::doMap($model, $data, false, false);
    }

    /**
     * Internal Mapping Class
     * Executes an Object Mapping.
     *
     * @param string|object      $model         the Model to be mapped or the namespace of it
     * @param array|object|Model $data          the data to be mapped
     * @param bool               $mapArray      If need to map as a set (array)
     * @param bool               $evaluateInput If need validate the input data
     *
     * @return bool|mixed|object|Model|RaiseModel the mapped object
     */
    private static function doMap($model, $data, bool $mapArray = false, bool $evaluateInput = false)
    {
        $mapper = new JsonMapper();

        if ($evaluateInput) {
            $mapper->bExceptionOnUndefinedProperty = true;
            $mapper->bExceptionOnMissingData = true;
        }

        $model = is_object($model) ? $model : new $model();

        try {
            return $mapArray ? $mapper->mapArray($data, [], $model) : $mapper->map((object) $data, $model);
        } catch (JsonMapper_Exception $e) {
            return false;
        }
    }

    /**
     * Map a set of Data into a specific Model type.
     *
     * @param string|object      $model the Model to be mapped or the namespace of it
     * @param array|object|Model $data  the data to be mapped
     *
     * @return bool|mixed|object|Model|RaiseModel the mapped object
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
     * @param string|object      $model the Model to be mapped or the namespace of it
     * @param array|object|Model $data  the data to be mapped
     *
     * @return bool|mixed|object|Model|RaiseModel the mapped object or false if not valid
     */
    public static function compare($model, $data)
    {
        return self::doMap($model, $data, false, true);
    }

    /**
     * Compare a set of Data and Map it.
     *
     * @param string|object      $model the Model to be mapped or the namespace of it
     * @param array|object|Model $data  the data to be mapped
     *
     * @return bool|mixed|object|Model|RaiseModel the mapped object or false if not valid
     */
    public static function compareSet($model, array $data)
    {
        return self::doMap($model, $data, true, true);
    }
}
