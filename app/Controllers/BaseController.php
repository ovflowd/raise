<?php

namespace App\Controllers;

use App\Models\Communication\Model;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class BaseController.
 */
abstract class BaseController
{
    /**
     * Register Process.
     *
     * @param null $data
     * @param Model|null $responseModel
     */
    public function register($data = null, Model $responseModel = null)
    {
        response()::setResponseModel(200, $responseModel, $data);
    }

    /**
     * List Process.
     *
     * @param array|null $data
     * @param Model $response
     * @param callable $callback
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
     * @param Select|null $query
     *
     * @return Select
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
