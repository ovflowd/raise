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
        $this->instruction = SQLWords::getUpdate() . SQLWords::getBlank() . $this->getEntity() . SQLWords::getBlank() .
            SQLWords::getSet() . SQLWords::getBlank() . $this->criteria->toSql() .
            SQLWords::getWhere() . SQLWords::getBlank() .
            $this->columnsValuesToUpdateFormat();
    }

    /**
     * Create pairs in the format: column = value based on columnValues attribute (@see SQLInstruction.php)
     *
     * @return string
     */
    private function columnsValuesToUpdateFormat()
    {
        $set = array();

        foreach ($this->columnValues as $column => $value) {
            $set[] = "{$column} = {$value}";
        }

        return implode(',', $set);
    }
}
