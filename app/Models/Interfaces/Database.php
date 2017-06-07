<?php

namespace App\Models\Interfaces;

use App\Models\Communication\Model;
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
     * @param string $table desired table to select
     * @param Select $query a Select query to search
     *
     * @return array|string|object selected content
     */
    public function select(string $table, Select $query);

    /**
     * Count number of Elements of a specific Query.
     *
     * @param string $table      the desired table
     * @param string $primaryKey the primary key to identify
     *
     * @return int amount of rows that the statement find
     */
    public function count(string $table, string $primaryKey);

    /**
     * Update an Element of the Database.
     *
     * @param string $table      desired table to update
     * @param string $primaryKey desired element to update
     * @param Model  $data       data to update
     *
     * @return array|string|object the result of the update
     */
    public function update(string $table, string $primaryKey, Model $data);
}
