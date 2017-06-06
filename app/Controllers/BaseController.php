<?php

namespace App\Controllers;

use App\Models\Response\ClientListResponse;
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
     * @param array|object|null $list
     * @param object|callable $callback
     */
    public function list($list = null, $callback = null)
    {
        $data = is_array($list) ? array_map(function ($model) {
            return $model->document;
        }, $list) : [$list];

        if (is_callable($callback)) {
            $callback($data);

            return;
        }

        response()::setResponseModel(200, new ClientListResponse(), array('clients' => $data));
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

        if (request()::query('id') !== false) {
            $query->where('META(document).id', request()::query('id'));

            return $query;
        }

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
