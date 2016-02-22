<?php

namespace UIoT\sql;

use UIoT\exceptions\NotArrayException;

/**
 * Class SQLSelect
 *
 * Represents a SELECT SQLInstruction
 *
 * @package UIoT\sql
 * @property array $selectColumns
 */
final class SQLSelect extends SQLInstruction
{
    /**
     * @var array column values
     */
    private $selectColumns;

    /**
     * Adds a column to the columns attribute | @see $selectColumns
     *
     * @param string $column
     */
    public function addColumn($column)
    {
        $this->selectColumns[] = $column;
    }

    /**
     * Sets an array of columns to the columns attribute | @see $selectColumns
     *
     * @param array $columns
     * @throws NotArrayException
     */
    public function addColumns($columns)
    {
        if (!is_array($columns))
            throw new NotArrayException("Columns should be in an array");
        $this->selectColumns = $columns;
    }

    /**
     * Generates a SELECT SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQL::SELECT() . SQL::BLANK() .
            $this->selectColumnsToSql() . SQL::BLANK() .
            SQL::FROM() . SQL::BLANK() .
            $this->getEntity() . SQL::BLANK() .
            SQL::WHERE() . SQL::BLANK() .
            $this->criteria->toSql();

    }

    /**
     * Converts the columns attribute to a SQL string
     *
     * @return string
     */
    public function selectColumnsToSql()
    {
        return implode(',', $this->selectColumns);
    }

}