<?php

final class SQL
{
    const SELECT = 'SELECT';
    const INSERT_INTO = 'INSERT INTO';
    const UPDATE = 'UPDATE';
    const DELETE  = 'DELETE';
    const WHERE = 'WHERE';
    const FROM = 'FROM';
    const VALUES = 'VALUES';
    const SET = 'SET';
    const OP_AND = 'AND';
    const OP_OR = 'OR';
    const LIMIT = 'LIMIT';
    const ORDER_BY = 'ORDER_BY';
    const OFFSET = 'OFFSET';
    const IN = 'IN';
    const IS_NULL = 'IS NULL';
    const IS_NOT_NULL = 'IS NOT NULL';
    const COMA = ',';
    const BLANK = " ";


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
        $sql = "AND";
        return constant('self::' . $sql);
    }

    static function OR_OP()
    {
        $sql = "OR";
        return constant('self::' . $sql);
    }

    static function LIMIT()
    {
        $sql = "LIMIT";
        return constant('self::' . $sql);
    }

    static function ORDER_BY()
    {
        $sql = "ORDER BY";
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
        $sql = "IS NULL";
        return constant('self::' . $sql);
    }

    static function IS_NOT_NULL()
    {
        $sql = "IS NULL";
        return constant('self::' . $sql);
    }

}