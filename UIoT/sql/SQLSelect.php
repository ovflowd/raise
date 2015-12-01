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

    public function add_columns($columns)
    {
        if(!is_array($columns))
             throw new NotArrayException("Columns should be in an array");
        $this->select_columns = $columns;
    }

    protected function generate_instruction()
    {
        $this->instruction = SQL::SELECT() . SQL::BLANK() .
            $this->select_columns_to_sql() . SQL::BLANK() .
            SQL::FROM() . SQL::BLANK() .
            $this->get_entity() . SQL::BLANK() .
            SQL::WHERE() . SQL::BLANK() .
            $this->criteria->to_sql();

    }

    public function select_columns_to_sql()
    {
        return implode(',', $this->select_columns);
    }

}