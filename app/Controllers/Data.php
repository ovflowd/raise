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

namespace App\Controllers;

use App\Models\Communication\Data as DataDefinition;
use App\Models\Communication\Model;
use App\Models\Response\Data as DataResponse;
use App\Models\Response\Message;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class Data.
 *
 * A Controller that Manages all Interactions with a Data
 * or a set of Data
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Data extends Controller
{
    /**
     * Register Process.
     *
     * Validated and Registers Data unto the Database
     *
     * @param object $data the payload as object from the Request
     * @param Model|null $response a Response Model to be used as Response
     */
    public function register($data = null, Model $response = null)
    {
        if (($dataModel = security()::validateBody('data', request()::body())) == false) {
            response()::setResponse(400, 'Missing required Parameters');

            return;
        }

        $service = database()->selectById('service', $dataModel->serviceId);

        $dataModel->data = array_filter($dataModel->data, function ($data) use ($service) {
            return empty(array_diff($service->parameters, array_keys((array)$data)));
        });

        database()->insert('data', $dataModel);

        parent::register(['details' => 'Data Registered Successfully', 'message' => 'Success'], new Message());
    }

    /**
     * List Process.
     *
     * List a set of Data or a single Data based on the Request Parameters
     *
     * @param array|object|null $data the given Data to be Mapped
     * @param Model $response the Response Model
     * @param callable $callback an optional callback to treat the mapping result
     */
    public function list($data = null, Model $response = null, $callback = null)
    {
        $query = $this->filter();

        $data = database()->select('data', $query);

        parent::list($data, new DataResponse(), function ($data) {
            return ['data' => json()::mapSet(new DataDefinition(), $data), 'message' => 'success'];
        });
    }

    /**
     * Filter Input Data.
     *
     * Used to filter and apply a several filters and patches
     * into a Query that will be used on the Database
     *
     * @param Select|null $query the Select Query class
     *
     * @return Select the Select Query class
     */
    protected function filter(Select $query = null)
    {
        global $token;

        $query = new Select();

        if (request()::query('serviceId') !== false) {
            $query->where('serviceId', request()::query('serviceId'));
        }

        if (request()::query('dataName') !== false) {
            $query->where('data', request()::query('dataName'));
        }

        return parent::filter($query);
    }
}
