<?php

/**
 * abstract class SQLInstruction
 * represents a abstract sql instruction SELECT, INSERT, UPDATE or DELETE
 * see more in https://dev.mysql.com/doc/
 */

abstract class SQLInstruction
{
    protected  $instruction; //Protected fields are just...
    protected  $criteria;
    protected  $entity;

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
     * @param SQLCriteria criteria
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

    abstract function get_instruction();


}