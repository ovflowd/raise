<?php


namespace UIoT\sql;

/**
 * Class SQLDelete
 * @package UIoT\sql
 */
final class SQLDelete extends SQLInstruction
{
    /**
     * Generates a DELETE SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQLWords::getUpdate() .
            SQLWords::getBlank() .
            $this->getEntity() .
            SQLWords::getBlank() .
            SQLWords::getSet() .
            SQLWords::getBlank() .
            SQLWords::getIsDeletedColumn(1) .
            SQLWords::getBlank() .
            SQLWords::getWhere() .
            SQLWords::getBlank() .
            $this->criteria->toSql();
    }

    /**
     * Configure Columns Values and Return It
     *
     * @return string
     */
    protected function configureValues()
    {
        return '';
    }

    /**
     * Configure Columns and Return It
     *
     * @return string
     */
    protected function configureColumns()
    {
        return '';
    }
}
