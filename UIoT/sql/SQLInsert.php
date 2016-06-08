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
        $this->instruction = SQLWords::getInsertInto() . SQLWords::getBlank() . $this->getEntity() .
            '(' . $this->getColumns() . ')' . SQLWords::getBlank() .
            SQLWords::getValues() . SQLWords::getBlank() .
            '(' . $this->getSqlValues() . ')' . SQLWords::getBlank();
    }

    /**
     * Return Generated Columns
     *
     * @return mixed
     */
    public function getColumns()
    {
        return implode(',', $this->columns);
    }

    /**
     * Get Prepared SQL Values
     *
     * @return string
     */
    private function getSqlValues()
    {
        return "'" . implode("','", $this->values) . "'";
    }
}
