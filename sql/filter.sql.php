<?php

include_once ROOT_REST_DIR. "/exceptions/invalid_sql_operator_exception.exc.php";
include_once ROOT_REST_DIR. "/sql/reserved_words.sql.php";

/**
 * class SQLFilter
 * represents filters on SQL instructions
 * example's: name = 'teste', age > 10, salary != 5000
 */

final class SQLFilter
{
    private $column_name;
    private $operator;
    private $value;

    /**
     * method __construct
     * instantiates a new SQLFilter
     * @param $column_name : string
     * @param $operator    : string -> (=, >, <, >=, <=, <>, !=, !<, !>)
     * @param $value       : mixed -> can be (boolean, float, int, string, array or null)
     *
     */

    public function __construct($column_name, $operator, $value)
    {
        self::set_column_name($column_name);
        self::set_operator($operator);
        self::set_value(self::value_to_string($value));
    }

    /**
     * method set_column_name
     * sets $column_name value
     * @param string $column_name
     */

    private function set_column_name($column_name)
    {
        $this->column_name = $column_name;
    }

    /**
     * method set_operator
     * sets $operator value
     * @param string $operator
     * @throws InvalidSqlOperatorException if param does not represent a sql operator
     */

    private function set_operator($operator)
    {
        if(!in_array($operator, SQL::ARITHMETIC_OPERATORS))
            throw new InvalidSqlOperatorException("invalid sql operator");

        $this->operator = $operator;
    }

     /**
     * method set_value
     * sets $value attribute value
     * @param string $value
     */

    private function set_value($value)
    {
        $this->value = $value;
    }

   public function to_sql()
   {
       return "{$this->column_name} {$this->operator} {$this->value}";
   }

    /**
     * method value_to_string
     * transforms $value to sql string
     * @param mixed $value : mixed -> (boolean, float, int, string, array or null)
     *
     * @return string|int|float $result
     */

     private function value_to_string($value)
     {
        if(is_array($value))
        {
            foreach($value as $v)
            {
                if(is_int($value) || is_float($value))
                {
                    $foo[] = "'$v'";
                }
		        else if(is_string($v))
		        {
 	                $foo[] = $v;
		        }
            }
	        $result =  '('.implode(',', $foo).')';
        }
        else if(is_string($value))
        {
            $result = "'$value'";
        }
        else if(is_null($value))
        {
            $result = 'NULL';
        }
        else if(is_bool($value))
        {
            $result = $value ? 'TRUE' : 'FALSE';
        }
        else
        {
            $result = $value;
        }

        return $result;
   }

}

