<?php

namespace App\Controllers;

use App\Models\Response\DataResponse;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class BaseController.
 */
abstract class BaseController
{
    /**
     * Register Process.
     *
     * @return mixed
     */
    abstract public function register();

    /**
     * List Process.
     *
     * @param string     $modelName
     * @param array|null $list
     */
    public function list(string $modelName = null, array $list = null)
    {
        $data = array_map(function ($model) use ($modelName) {
            return $model->{$modelName};
        }, $list);

        response()::setResponseModel(200, new DataResponse(), ['values' => $data]);
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

        $query->orderBy('serverTime '.(request()::query('order') === false ? 'DESC' : 'ASC'));

        return $query;
    }
}
