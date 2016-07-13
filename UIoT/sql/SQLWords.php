<?php

namespace UIoT\sql;

/**
 * Class SQLWords
 * @package UIoT\sql
 */
abstract class SQLWords
{
    /**
     * @var string Select
     */
    private static $select = 'SELECT';

    /**
     * @var string Insert
     */
    private static $insert = 'INSERT';

    /**
     * @var string Insert Into
     */
    private static $insertInto = 'INSERT INTO';

    /**
     * @var string Update
     */
    private static $update = 'UPDATE';

    /**
     * @var string Delete
     */
    private static $delete = 'DELETE';

    /**
     * @var string Delete From
     */
    private static $deleteFrom = 'DELETE FROM';

    /**
     * @var string Logical-Deleted Column
     */
    private static $deletedColumn = 'DELETED';

    /**
     * @var string Where
     */
    private static $where = 'WHERE';

    /**
     * @var string From
     */
    private static $from = 'FROM';

    /**
     * @var string Values
     */
    private static $values = 'VALUES';

    /**
     * @var string Set
     */
    private static $set = 'SET';

    /**
     * @var string And
     */
    private static $andOp = 'AND';

    /**
     * @var string Or
     */
    private static $orOp = 'OR';

    /**
     * @var string Limit
     */
    private static $limit = 'LIMIT';

    /**
     * @var string Order By
     */
    private static $orderBy = 'ORDER BY';

    /**
     * @var string Offset
     */
    private static $offset = 'OFFSET';

    /**
     * @var string In
     */
    private static $in = 'IN';

    /**
     * @var string Is Null
     */
    private static $isNull = 'IS NULL';

    /**
     * @var string Is Not Null
     */
    private static $isNotNull = 'IS NOT NULL';

    /**
     * @var string Comma
     */
    private static $comma = ',';

    /**
     * @var string Blank
     */
    private static $blank = " ";

    /**
     * @var array Arithmetic Operators
     */
    private static $arithmeticOperators = ['=', '>', '<', '>=', '<=', '<>', '!=', '!<', '!>'];

    /**
     * @var array Logic Operators
     */
    private static $logicOperators = ['OR', 'AND'];

    /**
     * @var string Equals Operators
     */
    private static $equalsOp = '=';

    /**
     * @var string Asterisk Operator
     */
    private static $asterisk = '*';

    /**
     * @var string Quotes Operator
     */
    private static $quotes = '\'';

    /**
     * @var int Always True
     */
    private static $alwaysTrue = 1;

    /**
     * @var string Start Parenthesis
     */
    private static $parenthesisBegin = '(';

    /**
     * @var string End Parenthesis
     */
    private static $parenthesisEnd = ')';

    /**
     * Get Select
     *
     * @return string
     */
    public static function getSelect()
    {
        return self::$select;
    }

    /**
     * Get Insert
     *
     * @return string
     */
    public static function getInsert()
    {
        return self::$insert;
    }

    /**
     * Get Insert Into
     *
     * @return string
     */
    public static function getInsertInto()
    {
        return self::$insertInto;
    }

    /**
     * Get Update
     *
     * @return string
     */
    public static function getUpdate()
    {
        return self::$update;
    }

    /**
     * Get Delete
     *
     * @return string
     */
    public static function getDelete()
    {
        return self::$delete;
    }

    /**
     * Get Delete From
     *
     * @return string
     */

    public static function getDeleteFrom()
    {
        return self::$deleteFrom;
    }

    /**
     * Get Deleted Column
     *
     * @return mixed
     */

    public static function getDeletedColumn()
    {
        return self::$deletedColumn;
    }

    /**
     * Get Is Deleted Column
     *
     * @param int $state
     * @return mixed
     */

    public static function getIsDeletedColumn($state)
    {
        return self::$deletedColumn . self::getBlank() . self::getArithmeticOperators()[0] . self::getBlank() . $state;
    }

    /**
     * Get Blank
     *
     * @return string
     */
    public static function getBlank()
    {
        return self::$blank;
    }

    /**
     * Get Arithmetic Operators
     *
     * @return array
     */
    public static function getArithmeticOperators()
    {
        return self::$arithmeticOperators;
    }

    /**
     * Get Where
     *
     * @return string
     */
    public static function getWhere()
    {
        return self::$where;
    }

    /**
     * Get From
     *
     * @return string
     */
    public static function getFrom()
    {
        return self::$from;
    }

    /**
     * Get Values
     *
     * @return string
     */
    public static function getValues()
    {
        return self::$values;
    }

    /**
     * Get Set
     *
     * @return string
     */
    public static function getSet()
    {
        return self::$set;
    }

    /**
     * Get And Operator
     *
     * @return string
     */
    public static function getAndOp()
    {
        return self::$andOp;
    }

    /**
     * Get Or Operator
     *
     * @return string
     */
    public static function getOrOp()
    {
        return self::$orOp;
    }

    /**
     * Get Limit
     *
     * @return string
     */
    public static function getLimit()
    {
        return self::$limit;
    }

    /**
     * Get Order By
     *
     * @return string
     */
    public static function getOrderBy()
    {
        return self::$orderBy;
    }

    /**
     * Get Offset
     *
     * @return string
     */
    public static function getOffset()
    {
        return self::$offset;
    }

    /**
     * Get In
     *
     * @return string
     */
    public static function getIn()
    {
        return self::$in;
    }

    /**
     * Get Is Null
     *
     * @return string
     */
    public static function getIsNull()
    {
        return self::$isNull;
    }

    /**
     * Get Is Not Null
     *
     * @return string
     */
    public static function getIsNotNull()
    {
        return self::$isNotNull;
    }

    /**
     * Get Comma
     *
     * @return string
     */
    public static function getComma()
    {
        return self::$comma;
    }

    /**
     * Get Logic Operators
     *
     * @return array
     */
    public static function getLogicOperators()
    {
        return self::$logicOperators;
    }

    /**
     * Get Equals Operators
     *
     * @return string
     */
    public static function getEqualsOp()
    {
        return self::$equalsOp;
    }

    /**
     * Get Always True Symbol
     *
     * @return int
     */
    public static function getAlwaysTrue()
    {
        return self::$alwaysTrue;
    }

    /**
     * Get Begin Parenthesis
     *
     * @return string
     */
    public static function getParenthesisBegin()
    {
        return self::$parenthesisBegin;
    }

    /**
     * Get End Parenthesis
     *
     * @return string
     */
    public static function getParenthesisEnd()
    {
        return self::$parenthesisEnd;
    }

    /**
     * Get Asterisk Operator
     *
     * @return string
     */
    public static function getAsterisk()
    {
        return self::$asterisk;
    }

    /**
     * Get Quotes Symbol
     *
     * @return string
     */
    public static function getQuotes()
    {
        return self::$quotes;
    }
}
