<?php

namespace UIoT\sql;

use UIoT\exceptions\InvalidValueException;

/**
 * abstract class SQLInstruction
 * represents a abstraction of a sql instruction SELECT, INSERT, UPDATE or DELETE
 * see more in https://dev.mysql.com/doc/
 */
abstract class SQLInstruction
{
    //Protected fields are just...
    protected $instruction;
    protected $criteria;
    protected $entity;
    protected $column_values;

    /**
     * method get_entity
     * returns entity value
     * @return string entity which represents table name
     *
     */

    final public function get_entity()
    {
        return $this->entity;
    }

    /**
     * method set_entity
     * sets entity value
     * @param string entity = represents table name
     *
     */

    final public function set_entity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * method get_columns
     * returns a string with all columns names separated by , (coma)
     * @return string all column names
     *
     */

    final public function get_columns()
    {
        return implode(',', array_keys($this->criteria));
    }

    /**
     * method get_values
     * returns a string with all values names separated by , (coma)
     * @return string all column names
     *
     */

    final public function get_values()
    {
        return implode(',', array_values($this->criteria));
    }

    /**
     * method set_criteria
     * sets criteria value
     * @param SQLCriteria $criteria
     *
     */

    public function set_criteria($criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * method get_instruction
     * returns instruction value
     * @return string instruction : represents a valid sql instruction (SELECT, INSERT, UPDATE, DELETE)
     *
     */

    public function get_instruction()
    {
        $this->generate_instruction();
        return $this->instruction;
    }

    /**
     * method generate_instruction
     * sets instruction value based on $criteria and $entity attributes
     * should be implemented by child classes
     */

    abstract protected function generate_instruction();

    /**
     * method set_row_data
     * relates table column with value
     * @param string $column
     * @param string|int|float|boolean|null $value
     * @throws InvalidValueException if value is not a string, int, float, bool or null
     */

    public function set_row_data($column, $value)
    {
        if (is_string($value) || is_bool($value) || is_integer($value) || is_float($value) || is_null($value))
            throw new InvalidValueException("Parameter value does not represents a valid type.
                                            Supported types are string, boolean, integer, float and null.");
        if (is_string($value)) {
            $value = addslashes($value);
            $this->column_values[$column] = "'$value'";
        } else if (is_bool($value)) {
            $this->column_values[$column] = $value ? 'TRUE' : 'FALSE';
        } else if (is_integer($value) || is_float($value)) {
            $this->column_values[$column] = $value;
        } else {
            $this->column_values[$column] = "NULL";
        }
    }

}