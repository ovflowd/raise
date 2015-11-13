<?php

namespace UIoT\sql;

/**
 * class SQLInsert
 * represents a update sql instruction
 */
final class SQLUpdate extends SQLInstruction
{

    /**
     * @see sql::SQLInstruction class
     */

    protected function generate_instruction()
    {
        $this->instruction = SQL::UPDATE() . SQL::BLANK() . $this->get_entity() .
            SQL::SET() . SQL::BLANK() .
            $this->columns_values_to_update_format() .
            SQL::BLANK() . SQL::WHERE() .
            $this->criteria->to_sql();
    }

    /**
     * method columns_values_to_update_format()
     * create pairs in the form: column = value based on column_values attribute
     * @return string
     */

    private function columns_values_to_update_format()
    {
        $set = array();

        foreach ($this->column_values as $column => $value) {
            $set[] = "{$column} = {$value}";
        }

        return implode(',', $set);
    }
}