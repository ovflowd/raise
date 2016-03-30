<?php

namespace UIoT\sql;

use UIoT\exceptions\CriteriaNotSupportedException;

/**
 * Class SQLInsert
 *
 * Represents an INSERT SQLInstruction
 *
 * @package UIoT/sql
 */
final class SQLInsert extends SQLInstruction
{

    private $values;
    
    public function getColumns()
    {
        return implode(',', $this->columns);
    }

    private function getSqlValues()
    {
        return "'".implode("','", $this->values)."'";
    }

    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * Generates a INSERT SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQL::INSERT_INTO() . SQL::BLANK() . $this->getEntity() .
            '(' . $this->getColumns() . ')' . SQL::BLANK() .
            SQL::VALUES() . SQL::BLANK() .
            '(' . $this->getSqlValues() . ')' . SQL::BLANK();
    }


}

