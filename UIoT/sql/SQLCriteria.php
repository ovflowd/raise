<?php

namespace UIoT\sql;


use UIoT\messages\InvalidSqlOperatorMessage;
use UIoT\messages\NotSqlFilterMessage;
use UIoT\util\MessageHandler;

/**
 * Class SQLExpression
 *
 * Represents a collection of SQLFilters related by logic operands.
 * Example: name = 'tests' AND age > 10 OR salary != 5000
 *
 * @package UIoT\sql
 */
final class SQLCriteria
{
    /**
     * @var array
     */
    private $filters;

    /**
     * Adds a SQLFilter to an expression linked by a logic operation.
     *
     * @param SQLFilter $filter
     * @param string $logicOperation
     * @throws InvalidSqlOperatorMessage
     * @throws NotSqlFilterMessage
     */
    public function addFilter($filter, $logicOperation)
    {
        if (!($filter instanceof SQLFilter)) {
            MessageHandler::getInstance()->endExecution(new NotSqlFilterMessage("Parameter is not a instance of SQLFilter"));
        }

        if (!in_array($logicOperation, SQL::LOGIC_OPERATORS)) {
            MessageHandler::getInstance()->endExecution(new InvalidSqlOperatorMessage("parameter is not a valid sql logic operator"));
        }

        $this->filters[] = $logicOperation;
        $this->filters[] = $filter->toSql();
    }


    /**
     * Creates a SQL string based on filters attribute. | @see $filters
     *
     * @return string $sql
     */
    public function toSql()
    {
        if (empty($this->filters)) {
            return SQL::ALWAYS_TRUE;
        }

        $sql = '';

        foreach ($this->filters as $key => $filter) {
            if ($key != 0) {
                $sql .= $filter . SQL::BLANK;
            }
        }

        return $sql;
    }

    /**
     * Get Filters
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }
}