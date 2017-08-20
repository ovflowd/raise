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

namespace App\Models\Interfaces;

use App\Models\Communication\Model;
use Koine\QueryBuilder;
use Koine\QueryBuilder\Statements\Select;

/**
 * Interface Database.
 *
 * An Interface used to Describe
 * the default methods of an DatabaseHandler
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
interface Database
{
    /**
     * Connect to the Database.
     *
     * @param array|object $connection the connection string
     */
    public function connect($connection);

    /**
     * Destroy the Connection.
     *
     * (only if the connection it's already active)
     */
    public function destroy();

    /**
     * Insert Data on Database.
     *
     * @param string $table      desired table to insert
     * @param Model  $data       data to be inserted
     * @param string $primaryKey defined primary key or generated
     *
     * @return int|string generated or defined primary key or the result of the primary key
     */
    public function insert(string $table, Model $data, string $primaryKey);

    /**
     * Select Data on Database.
     *
     * @param string              $table desired table to select
     * @param Select|QueryBuilder $query a Select query to search
     *
     * @return array|string|object selected content
     */
    public function select(string $table, Select $query);

    /**
     * Update an Element of the Database.
     *
     * @param string       $table      desired table to update
     * @param string       $primaryKey desired element to update
     * @param Model|object $data       data to update
     *
     * @return array|string|object the result of the update
     */
    public function update(string $table, string $primaryKey, $data);

    /**
     * Delete an Element of the Database.
     *
     * @param string $table      desired table to update
     * @param string $primaryKey desired element to delete
     */
    public function delete(string $table, string $primaryKey);

    /**
     * Get the Database Connection Handler.
     *
     * @return mixed|bool
     */
    public function getConnection();
}
