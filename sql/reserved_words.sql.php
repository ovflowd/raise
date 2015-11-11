<?php

final class SQL
{
    const SELECT = 'SELECT';
    const INSERT_INTO = 'INSERT INTO';
    const UPDATE = 'UPDATE';
    const DELETE  = 'DELETE FROM';
    const WHERE = 'WHERE';
    const FROM = 'FROM';
    const VALUES = 'VALUES';
    const SET = 'SET';
    const AND_OP = 'AND';
    const OR_OP = 'OR';
    const LIMIT = 'LIMIT';
    const ORDER_BY = 'ORDER_BY';
    const OFFSET = 'OFFSET';
    const IN = 'IN';
    const IS_NULL = 'IS NULL';
    const IS_NOT_NULL = 'IS NOT NULL';
    const COMA = ',';
    const BLANK = " ";
    const ARITHMETIC_OPERATORS = ['=', '>', '<', '>=', '<=', '<>', '!=', '!<', '!>'];
    const LOGIC_OPERATORS = ['OR', 'AND'];


    static function SELECT()
    {
        $sql = "SELECT";
        return constant('self::' . $sql);
    }

    static function INSERT_INTO()
    {
        $sql = "INSERT INTO";
        return constant('self::' . $sql);
    }

    static function UPDATE()
    {
        $sql = "UPDATE";
        return constant('self::' . $sql);
    }

    static function DELETE()
    {
        $sql = "DELETE";
        return constant('self::' . $sql);
    }

    static function WHERE()
    {
        $sql = "WHERE";
        return constant('self::' . $sql);
    }

    static function FROM()
    {
        $sql = "FROM";
        return constant('self::' . $sql);
    }

    static function VALUES()
    {
        $sql = "VALUES";
        return constant('self::' . $sql);
    }

    static function SET()
    {
        $sql = "SET";
        return constant('self::' . $sql);
    }

    static function AND_OP()
    {
        $sql = "AND_OP";
        return constant('self::' . $sql);
    }

    static function OR_OP()
    {
        $sql = "OR_OP";
        return constant('self::' . $sql);
    }

    static function LIMIT()
    {
        $sql = "LIMIT";
        return constant('self::' . $sql);
    }

    static function ORDER_BY()
    {
        $sql = "ORDER_BY";
        return constant('self::' . $sql);
    }

    static function OFFSET()
    {
        $sql = "OFFSET";
        return constant('self::' . $sql);
    }

    static function IN()
    {
        $sql = "IN";
        return constant('self::' . $sql);
    }

    static function IS_NULL()
    {
        $sql = "IS_NULL";
        return constant('self::' . $sql);
    }

    static function IS_NOT_NULL()
    {
        $sql = "IS_NOT_NULL";
        return constant('self::' . $sql);
    }

    static function BLANK()
    {
        $sql = "BLANK";
        return constant('self::' . $sql);
    }

    static function COMA()
    {
        $sql = "COMA";
        return constant('self::' . $sql);
    }

}