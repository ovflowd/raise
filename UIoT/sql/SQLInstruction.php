<?php

namespace UIoT\sql;

use UIoT\messages\NotArrayMessage;
use UIoT\model\MetaProperty;

/**
 * Abstract Class SQLInstruction
 *
 * Represents a abstraction of a sql instruction SELECT, INSERT, UPDATE or DELETE.
 * See more at https://dev.mysql.com/doc/
 *
 * @package UIoT/sql
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
     * @var string Entity of the SQL Instruction
     */
    protected $entity;

    /**
     * @var MetaProperty[] SQL columns
     */
    protected $properties = [];

    /**
     * @var array SQL column values
     */
    protected $values = [];

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
     * Return Generated Columns
     *
     * @return mixed
     */
    public function getProperties()
    {
        return implode(SQLWords::getComma() . SQLWords::getBlank(), $this->properties);
    }

    /**
     * Sets an array of columns to the columns attribute | @see $selectColumns
     *
     * @param MetaProperty[] $properties
     * @throws NotArrayMessage
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * Get Columns Values
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Set Columns Values
     *
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;
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
     * Configure Columns Values and Return It
     *
     * @return string
     */
    protected abstract function configureValues();

    /**
     * Configure Columns and Return It
     *
     * @return string
     */
    protected abstract function configureColumns();
}
