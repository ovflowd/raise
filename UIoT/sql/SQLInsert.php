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
    /**
     * Not supported by INSERT instructions.
     *
     * @param SQLCriteria $criteria
     * @throws CriteriaNotSupportedException
     */
    public function setCriteria($criteria)
    {
        throw new CriteriaNotSupportedException("Insert operation does not support criteria objects");
    }

    /**
     * Generates a INSERT SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQL::INSERT_INTO() . SQL::BLANK() . $this->getEntity() .
            '(' . $this->getColumns() . ')' . SQL::BLANK() .
            SQL::VALUES() . SQL::BLANK() .
            '(' . $this->getValues() . ')' . SQL::BLANK();
    }


}

