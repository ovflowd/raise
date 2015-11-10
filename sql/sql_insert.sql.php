<?php

final class SQLInsert extends SQLInstruction
{
    private $column_values;

    /**
     * method set_row_data
     * relates table columns and respective values
     * @param string $column
     * @param string|int|float|boolean|null $value
     * @throws InvalidValueException if value is not a string, int, float, bool or null
     */

    public function set_row_data($column, $value)
    {
        if(is_string($value) || is_bool($value) || is_integer($value) || is_float($value) || is_null($value))
            throw new InvalidValueException("Parameter value does not represents a valid type.
                                            supported types are string, boolean, integer, float and null.");
        if(is_string($value))
        {
            $value = addslashes($value);
            $this->column_values[$column] = "'$value'";
        }
        else if(is_bool($value))
        {
            $this->column_values[$column] = $value ? 'TRUE' : 'FALSE';
        }
        else if(is_integer($value) || is_float($value))
        {
            $this->column_values[$column] = $value;
        }
        else
        {
            $this->column_values[$column] = $value;
        }
    }

    public function set_criteria($criteria)
    {
        throw new CriteriaNotSupportedException("Insert operation does not support criteria objects");
    }

    /**
     * method get_instruction
     * @see sql::SqlInstruction
     */
    public function get_instruction()
    {
        $this->generate_instruction();
        return $this->instruction;
    }

    /**
     * method generate_instruction
     * sets instruction value based on $criteria and $entity attributes
     */

    private function generate_instruction()
    {
        $this->instruction = SQL::INSERT_INTO().SQL::BLANK.
                             '('.$this->get_columns().')'.SQL::BLANK.
                             SQL::VALUES().SQL::BLANK.
                             '('.$this->get_values().')'.SQL::BLANK;
    }
}
