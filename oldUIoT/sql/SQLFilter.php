<?php

namespace UIoT\sql;

use UIoT\messages\InvalidSqlOperatorMessage;
use UIoT\util\MessageHandler;

/**
 * Class SQLFilter
 *
 * Represents filters on SQL instructions.
 * Examples: name = 'tests', age > 10, salary != 5000
 *
 * @package UIoT/sql
 */
final class SQLFilter
{
    /**
     * @var string Column Name
     */
    private $columnName;

    /**
     * @var string Operator
     */
    private $operator;

    /**
     * @var mixed Value
     */
    private $value;

    /**
     * SQLFilter constructor
     *
     * @param string $columnName
     * @param string $operator (=, >, <, >=, <=, <>, !=, !<, !>)
     * @param mixed $value (boolean, float, int, string, array or null)
     */
    public function __construct($columnName, $operator, $value)
    {
        $this->setColumnName($columnName);
        $this->setOperator($operator);
        $this->setValue($this->valueToString($value));
    }

    /**
     * Sets the column name attribute. | @see $columnName
     *
     * @param string $columnName
     */
    private function setColumnName($columnName)
    {
        $this->columnName = $columnName;
    }

    /**
     * Sets the operator attribute. | @see $operator
     *
     * @param string $operator
     * @throws InvalidSqlOperatorMessage
     */
    private function setOperator($operator)
    {
        if (!in_array($operator, SQLWords::getArithmeticOperators())) {
            MessageHandler::getInstance()->endExecution(new InvalidSqlOperatorMessage('Invalid SQL Operator'));
        }

        $this->operator = $operator;
    }

    /**
     * Sets the value attribute | @see $value
     *
     * @param string $value
     */
    private function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Converts the value attribute to a string. | @see $value
     *
     * @param mixed $value (boolean, float, int, string, array or null)
     * @return string|int|float
     */
    private function valueToString($value)
    {
        return is_numeric($value) ? $value : SQLWords::getQuotes() . $value . SQLWords::getQuotes();
    }

    /**
     * Combines the class attributes to a SQL string.
     *
     * @return string
     */
    public function toSql()
    {
        return "{$this->columnName} {$this->operator} {$this->value}";
    }
}
