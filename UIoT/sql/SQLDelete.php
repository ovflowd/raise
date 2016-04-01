<?php


namespace UIoT\sql;

use UIoT\exceptions\RowDataValueNotSupportedException;

/**
 * Class SQLDelete
 *
 * @package UIoT\sql
 */
final class SQLDelete extends SQLInstruction
{
    /**
     * Sets data into a specified row (Not supported for DELETE).
     *
     * @param string $column
     * @param bool|float|int|string|null $value
     * @throws RowDataValueNotSupportedException
     */
    public function setRowData($column, $value)
    {
        throw new RowDataValueNotSupportedException("DELETE instructions do not support row values");
    }

    /**
     * Generates a DELETE SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQL::DELETE() . SQL::BLANK() . $this->getEntity() . SQL::BLANK() .
            SQL::WHERE() . SQL::BLANK() . $this->criteria->toSql();
    }
}
