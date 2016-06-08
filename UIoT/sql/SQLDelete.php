<?php


namespace UIoT\sql;

use UIoT\messages\RowDataValueNotSupportedMessage;
use UIoT\util\MessageHandler;

/**
 * Class SQLDelete
 * @package UIoT\sql
 */
final class SQLDelete extends SQLInstruction
{
    /**
     * Sets data into a specified row (Not supported for DELETE).
     *
     * @param string $column
     * @param bool|float|int|string|null $value
     * @throws RowDataValueNotSupportedMessage
     */
    public function setRowData($column, $value)
    {
        MessageHandler::getInstance()->endExecution(new RowDataValueNotSupportedMessage('DELETE instructions do not support row values'));
    }

    /**
     * Generates a DELETE SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQLWords::getDelete() . SQLWords::getBlank() . $this->getEntity() . SQLWords::getBlank() .
            SQLWords::getWhere() . SQLWords::getBlank() . $this->criteria->toSql();
    }
}
