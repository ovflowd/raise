<?php

include_once ROOT_REST_DIR. "/exceptions/not_sql_filter_exception.exc.php";

/**
 * class SQLExpression
 * class that represents a collection of SQLFilters related by logic operands
 * example: name = 'teste' AND age > 10 OR salary != 5000
 */

final class SQLExpression
{
    private $filters;

    /**
     * method __construct
     * instantiates a new SQLExpression
     * @param $filter : SQLFielter
     *
     */

    public function __construct($filter)
    {
	    $this->filters[] = $filter->to_sql();
    }

    /**
     * method add_filter
     * adds a SQLFilter on expression linked by logic_operator
     * @param SQLFilter $filter
     * @param string $logic_operation
     * @throws InvalidSqlOperatorException if $logic_operation is not a valid sql operator
     * @throws NotSqlFilterException if $filter does is not a instance of SQLFilter
     */

    public function add_filter($filter, $logic_operation)
    {
        if(!($filter instanceof SQLFilter))
            throw new NotSqlFilterException("parameter is not a instance of SQLFilter");

        if(!in_array($logic_operation, SQL::LOGIC_OPERATORS))
            throw new InvalidSqlOperatorException("parameter is not a valid sql logic operator");

         $this->filters[] = $logic_operation;
         $this->filters[] = $filter->to_sql();
    }


    /**
     * method to_sql
     * creates a sql string based on filters
     * @return string $sql
     */

    public function to_sql()
    {
        $sql = "";

        foreach($this->filters as $filter)
        {
            $sql .= $filter." ";
        }

        return $sql;
    }	
			
}
