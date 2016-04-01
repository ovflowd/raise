<?php

namespace UIoT\sql;

/**
 * Class SQLUpdate
 *
 * Represent an UPDATE SQLInstruction
 *
 * @package UIoT\sql
 */
final class SQLUpdate extends SQLInstruction
{

    /**
     * Generates an UPDATE SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQL::UPDATE() . SQL::BLANK() . $this->getEntity() . SQL::BLANK() .
            SQL::SET() . SQL::BLANK() . $this->criteria->toSql() .
            SQL::WHERE() . SQL::BLANK() .
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
