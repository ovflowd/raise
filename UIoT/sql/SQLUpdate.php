<?php

namespace UIoT\sql;

/**
 * Class SQLUpdate
 * @package UIoT\sql
 */
final class SQLUpdate extends SQLInstruction
{
    /**
     * Generates an UPDATE SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQLWords::getUpdate() .
            SQLWords::getBlank() .
            $this->getEntity() .
            SQLWords::getBlank() .
            SQLWords::getSet() .
            SQLWords::getBlank() .
            $this->configureColumns() .
            SQLWords::getBlank() .
            SQLWords::getWhere() .
            SQLWords::getBlank() .
            $this->criteria->toSql();
    }

    /**
     * Configure Columns and Return It
     *
     * @return string
     */
    protected function configureColumns()
    {
        $columnSet = array();

        foreach ($this->columns as $column => $value) {
            $columnSet[] = "{$value} = {$column}";
        }

        return implode(', ', $columnSet);
    }
}
