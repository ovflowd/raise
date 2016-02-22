<?php

namespace UIoT\sql;


use UIoT\exceptions\InvalidSqlOperatorException;
use UIoT\exceptions\NotSqlFilterException;

/**
 * Class SQLExpression
 *
 * Represents a collection of SQLFilters related by logic operands.
 * Example: name = 'test' AND age > 10 OR salary != 5000
 *
 * @package UIoT\sql
 * @property array $filters
 */
final class SQLCriteria
{
    /**
     * @var array (SQLFilter)
     */
    private $filters;

    /**
     * SQLCriteria constructor
     */
    public function __construct()
    {
    }

    /**
     * Adds a SQLFilter to an expression linked by a logic operation.
     *
     * @param SQLFilter $filter
     * @param string $logicOperation
     * @throws InvalidSqlOperatorException
     * @throws NotSqlFilterException
     */
    public function addFilter($filter, $logicOperation)
    {
        if (!($filter instanceof SQLFilter))
            throw new NotSqlFilterException("parameter is not a instance of SQLFilter");

        if (!in_array($logicOperation, SQL::LOGIC_OPERATORS))
            throw new InvalidSqlOperatorException("parameter is not a valid sql logic operator");

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
        if (empty($this->filters))
            return SQL::ALWAYS_TRUE();

        $sql = "";
        foreach ($this->filters as $key => $filter) {
            if ($key != 0) //eliminating first logic operator
                $sql .= $filter . SQL::BLANK();
        }

        return $sql;
    }

}

