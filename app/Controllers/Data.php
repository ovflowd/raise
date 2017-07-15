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
     * @param object     $data     the payload as object from the Request
     * @param Model|null $response a Response Model to be used as Response
     */
    public function register($data = null, Model $response = null)
    {
        response()::message(400, 'Missing required Parameters');

        $dataIds = array_filter(array_map(function ($dataModel) {
            if (($dataModel = security()::validateBody('data', $dataModel))) {
                $dataId = database()->insert('data', $dataModel);

                logger()::log($dataId, 'data', 'a data set was registered on raise.');

                return $dataId;
            }
        }, request()::body()));

        if (count($dataIds) > 0) {
            parent::register(['details' => 'Data Registered Successfully', 'message' => 'Success'], new Message());
        }
    }

    /**
     * List Process.
     *
     * List a set of Data or a single Data based on the Request Parameters
     *
     * @param array|object|null $data     the given Data to be Mapped
     * @param Model             $response the Response Model
     * @param callable          $callback an optional callback to treat the mapping result
     */
    public function list($data = null, Model $response = null, $callback = null)
    {
        $query = $this->filter();

        $data = database()->select('data', $query);

        parent::list($data, new DataResponse(), function ($data) {
            return ['data' => json()::mapSet(new DataDefinition(), $data)];
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

        $query->where('clientId', $token()->clientId);

        if (request()::query('serviceId') !== false) {
            $query->where('serviceId', request()::query('serviceId'));
        }

        if (($name = request()::query('parameter')) !== false) {
            $query->where("'{$name}' IN parameters");
        }

        return parent::filter($query);
    }
}
