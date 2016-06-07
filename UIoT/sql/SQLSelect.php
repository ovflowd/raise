<?php

namespace UIoT\sql;

/**
 * Class SQLSelect
 * @package UIoT\sql
 */
final class SQLSelect extends SQLInstruction
{
    /**
     * Adds a column to the columns attribute | @see $selectColumns
     *
     * @param string $column
     */
    public function addColumn($column)
    {
        $this->columns[] = $column;
    }

    /**
     * Generates a SELECT SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQL::SELECT . SQL::BLANK .
            $this->selectColumnsToSql() . SQL::BLANK .
            SQL::FROM . SQL::BLANK .
            $this->getEntity() . SQL::BLANK .
            SQL::WHERE . SQL::BLANK .
            $this->criteria->toSql();
    }

    /**
     * Converts the columns attribute to a SQL string
     *
     * @return string
     */
    public function selectColumnsToSql()
    {
        if (!is_null($this->columns)) {
            return implode(',', $this->columns);
        }

        return '';
    }
}