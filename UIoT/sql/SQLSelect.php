<?php

namespace UIoT\sql;

final class SQLSelect extends SQLInstruction
{
    private $select_columns; //represents an array of columns that should be returned

    /**
     * method add_column
     * adds a column in columns attribute
     * @param string $column
     */

    public function add_column($column)
    {
        $this->select_columns[] = $column;
    }

    protected function generate_instruction()
    {
        $this->instruction = SQL::SELECT() . SQL::BLANK() .
            $this->select_columns_to_sql() . SQL::BLANK() .
            $this->get_entity() . SQL::BLANK() .
            SQL::WHERE() . SQL::BLANK() .
            $this->criteria->to_sql();

        //TODO: support to ORDER BY, OFFSET, LIMIT
        //TODO: support to JOINS

    }

    public function select_columns_to_sql()
    {
        return implode(',', $this->select_columns);
    }

}