<?php

namespace UIoT\sql;

/**
 * Class SQL
 * @package UIoT\sql
 */
final class SQL
{
    const SELECT = 'SELECT';
    const INSERT = 'INSERT';
    const INSERT_INTO = 'INSERT INTO';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE FROM';
    const WHERE = 'WHERE';
    const FROM = 'FROM';
    const VALUES = 'VALUES';
    const SET = 'SET';
    const AND_OP = 'AND';
    const OR_OP = 'OR';
    const LIMIT = 'LIMIT';
    const ORDER_BY = 'ORDER BY';
    const OFFSET = 'OFFSET';
    const IN = 'IN';
    const IS_NULL = 'IS NULL';
    const IS_NOT_NULL = 'IS NOT NULL';
    const COMMA = ',';
    const BLANK = " ";
    const ARITHMETIC_OPERATORS = ['=', '>', '<', '>=', '<=', '<>', '!=', '!<', '!>'];
    const LOGIC_OPERATORS = ['OR', 'AND'];
    const EQUALS_OP = '=';
    const ALWAYS_TRUE = 1;
}