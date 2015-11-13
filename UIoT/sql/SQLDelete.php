<?php


namespace UIoT\sql;

use UIoT\exceptions\RowDataValueNotSupportedException;

final class SQLDelete extends SQLInstruction
{
    /**
     * method set_row_data
     * not supported for delete
     * @param string $column
     * @param bool|float|int|null|string $value
     * @throws RowDataValueNotSupportedException
     */

    public function set_row_data($column, $value)
    {
        throw new RowDataValueNotSupportedException("Delete instructions does not support row_data values");
    }

    /**
     * @see sql::SQLInstruction class
     */

    protected function generate_instruction()
    {
        $this->instruction = SQL::DELETE() . SQL::BLANK() . $this->get_entity() .
            SQL::WHERE() . SQL::BLANK() .
            $this->criteria->to_sql();
    }
}