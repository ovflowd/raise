<?php

namespace UIoT\sql;

use UIoT\exceptions\InvalidValueException;

/**
 * Abstract Class SQLInstruction
 *
 * Represents a abstraction of a sql instruction SELECT, INSERT, UPDATE or DELETE.
 * See more at https://dev.mysql.com/doc/
 *
 * @package UIoT/sql
 * @property string $instruction
 * @property SQLCriteria $criteria
 * @property string $entity
 * @property array $columnValues
 *
 */
abstract class SQLInstruction
{
    /**
     * @var string SQL Instruction
     */
    protected $instruction;

    /**
     * @var SQLCriteria
     */
    protected $criteria;

    /**
     * @var srting Entity of the SQL Instruction
     */
    protected $entity;

    /**
     * @var array SQL column values
     */
    protected $columnValues;

    /**
     * Gets the entity attribute. | @see $entity
     *
     * @return string
     */
    final public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Sets the entity attribute. | @see $entity
     * @param string $entity
     */
    final public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Returns a string with all columns names separated by ','
     *
     * @return string
     */
    final public function getColumns()
    {
        return implode(',', array_keys($this->criteria));
    }

    /**
     * Returns a string with all values names separated by ','
     *
     * @return string
     */
    final public function getValues()
    {
        return implode(',', array_values($this->criteria));
    }

    /**
     * Sets the criteria attribute. | @see $criteria
     *
     * @param SQLCriteria $criteria
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * Generates and returns a valid SQLInstruction (SELECT, INSERT, UPDATE, DELETE)
     *
     * @return string
     */
    public function getInstruction()
    {
        $this->generateInstruction();
        return $this->instruction;
    }

    /**
     * Sets instruction based on criteria and entity attributes | @see $criteria, $entity
     *
     * Implemented by child classes.
     */
    abstract protected function generateInstruction();

    /**
     * Sets a value into a row.
     *
     * @param string $column
     * @param string|int|float|boolean|null $value
     * @throws InvalidValueException
     */
    public function setRowData($column, $value)
    {
        if (is_string($value) || is_bool($value) || is_integer($value) || is_float($value) || is_null($value))
            throw new InvalidValueException("Parameter value does not represents a valid type.
                                            Supported types are string, boolean, integer, float and null.");
        if (is_string($value)) {
            $value = addslashes($value);
            $this->columnValues[$column] = "'$value'";
        } else if (is_bool($value)) {
            $this->columnValues[$column] = $value ? 'TRUE' : 'FALSE';
        } else if (is_integer($value) || is_float($value)) {
            $this->columnValues[$column] = $value;
        } else {
            $this->columnValues[$column] = "NULL";
        }
    }

}