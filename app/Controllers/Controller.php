<?php

namespace App\Controllers;

use App\Models\Communication\Model;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class Controller
 *
 * A Controller is a manager of a specific model schema,
 * a RAISe Controller manages everything related to a Model
 *
 * @see https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller MVC Controller Pattern
 *
 * @version 2.0.0
 * @since 2.0.0
 */
abstract class Controller
{
    /**
     * Register Process.
     *
     * Validated and Registers Models unto the Database
     *
     * @param object $data the payload as object from the Request
     * @param Model|null $responseModel a Response Model to be used as Response
     */
    public function register($data = null, Model $responseModel = null)
    {
        response()::setResponseModel(200, $responseModel, $data);
    }

    /**
     * List Process.
     *
     * List a set of Models or a single Model based on the Request Parameters
     *
     * @param array|object|null $data the given Data to be Mapped
     * @param Model $response the Response Model
     * @param callable $callback an optional callback to treat the mapping result
     */
    public function list($data = null, Model $response = null, $callback = null)
    {
        $data = array_map(function ($model) {
            return $model->document;
        }, $data);

        response()::setResponseModel(200, $response, is_callable($callback) ?
            $callback($data) : $data);
    }

    /**
     * Filter Input Data.
     *
     * Used to filter and apply a several filters and patches
     * into a Query that will be used on the Database
     *
     * This method has the default filters that all requests may have
     *
     * @param Select|null $query the Select Query class
     *
     * @return Select the Select Query class
     */
    protected function filter(Select $query = null)
    {
        $query = $query == null ? new Select() : $query;

        if (request()::query('tags') !== false) {
            array_walk(explode(':', request()::query('tags')), function ($tag) use ($query) {
                $query->where("'{$tag}' IN tags");
            });
        }

        if (request()::query('interval') !== false) {
            $interval = explode(':', request()::query('interval'));

            $query->where('clientTime', $interval[0], '>=');
            $query->where('clientTime', $interval[1], '<=');
        }

        if (request()::query('limit') !== false) {
            $query->limit(request()::query('limit'));
        }

        $query->orderBy('clientTime ' . (request()::query('order') === false ? 'DESC' : 'ASC'));

        return $query;
    }
}
