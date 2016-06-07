<?php

namespace UIoT\sql;

/**
 * Class SQLInsert
 * @package UIoT/sql
 */
final class SQLInsert extends SQLInstruction
{
    /**
     * @var mixed Values
     */
    private $values;

    /**
     * @param $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * Generates a INSERT SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQL::INSERT_INTO . SQL::BLANK . $this->getEntity() .
            '(' . $this->getColumns() . ')' . SQL::BLANK .
            SQL::VALUES . SQL::BLANK .
            '(' . $this->getSqlValues() . ')' . SQL::BLANK;
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return implode(',', $this->columns);
    }

    /**
     * @return string
     */
    private function getSqlValues()
    {
        return "'" . implode("','", $this->values) . "'";
    }
}
