<?php

namespace UIoT\sql;

/**
 * Class SQLSelect
 * @package UIoT\sql
 */
final class SQLSelect extends SQLInstruction
{
    /**
     * Generates a SELECT SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQLWords::getSelect() .
            SQLWords::getBlank() .
            $this->configureColumns() .
            SQLWords::getBlank() .
            SQLWords::getFrom() .
            SQLWords::getBlank() .
            $this->getEntity() .
            SQLWords::getBlank() .
            SQLWords::getWhere() .
            SQLWords::getBlank() .
            $this->criteria->toSql() .
            SQLWords::getAndOp() .
            SQLWords::getBlank() .
            SQLWords::getIsDeletedColumn(0);
    }

    /**
     * Configure Columns and Return It
     *
     * @return string
     */
    protected function configureColumns()
    {
        if ($this->columns == null) {
            return '*';
        }

        return implode(', ', $this->columns);
    }
}
