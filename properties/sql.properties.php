<?php

class SQL
{
    const SELECT = 'SELECT';
    const INSERT_INTO = 'INSERT_INTO';
    const UPDATE = 'UPDATE';
    const DELETE  = 'DELETE';
    const WHERE = 'WHERE';
    const FROM = 'FROM';
    const VALUES = 'VALUES';
    const SET = 'SET';
    const BLANK = " ";

    static function SELECT()
    {
        $sql = "SELECT";
        return constant('self::' . $sql);
    }

    static function INSERT_INTO()
    {
        $sql = "INSERT_INTO";
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

    static function VALUES()
    {
        $sql = "VALUES";
        return constant('self::' . $sql);
    }

    static function FROM()
    {
        $sql = "FROM";
        return constant('self::' . $sql);
    }

}