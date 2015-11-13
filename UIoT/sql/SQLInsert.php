<?php

namespace UIoT\sql;

use UIoT\exceptions\CriteriaNotSupportedException;

/**
 * class SQLInsert
 * represents a insert sql instruction
 */
final class SQLInsert extends SQLInstruction
{
    /**
     * method set_criteria
     * not supported for inserts
     * @param $criteria
     * @throws CriteriaNotSupportedException
     */

    public function set_criteria($criteria)
    {
        throw new CriteriaNotSupportedException("Insert operation does not support criteria objects");
    }

    /**
     * @see sql::SQLInstruction class
     */

    protected function generate_instruction()
    {
        $this->instruction = SQL::INSERT_INTO() . SQL::BLANK() . $this->get_entity() .
            '(' . $this->get_columns() . ')' . SQL::BLANK() .
            SQL::VALUES() . SQL::BLANK() .
            '(' . $this->get_values() . ')' . SQL::BLANK();
    }


}
