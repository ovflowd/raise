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
        $this->instruction = SQLWords::getSelect() . SQLWords::getBlank() .
            $this->selectColumnsToSql() . SQLWords::getBlank() .
            SQLWords::getFrom() . SQLWords::getBlank() .
            $this->getEntity() . SQLWords::getBlank() .
            SQLWords::getWhere() . SQLWords::getBlank() .
            $this->criteria->toSql() . SQLWords::getBlank() .
            SQLWords::getAndOp() . SQLWords::getBlank() .
            SQLWords::getIsDeletedColumn(0);
    }

    /**
     * Converts the columns attribute to a SQL string
     *
     * @return string
     */
    public function selectColumnsToSql()
    {
        if ($this->columns == null) {
            return '*';
        }

        return implode(',', $this->columns);
    }
}
