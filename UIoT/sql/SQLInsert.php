<?php

namespace UIoT\sql;

/**
 * Class SQLInsert
 * @package UIoT/sql
 */
final class SQLInsert extends SQLInstruction
{
    /**
     * Generates a INSERT SQLInstruction | @see SQLInstruction.php
     */
    protected function generateInstruction()
    {
        $this->instruction = SQLWords::getInsertInto() .
            SQLWords::getBlank() .
            $this->getEntity() .
            SQLWords::getParenthesisBegin() .
            $this->getProperties() .
            SQLWords::getParenthesisEnd() .
            SQLWords::getBlank() .
            SQLWords::getValues() .
            SQLWords::getBlank() .
            SQLWords::getParenthesisBegin() .
            $this->configureValues() .
            SQLWords::getParenthesisEnd() .
            SQLWords::getBlank();
    }

    /**
     * Configure Columns Values and Return It
     *
     * @return string
     */
    protected function configureValues()
    {
        return
            SQLWords::getQuotes() .
            implode(SQLWords::getQuotes() .
                SQLWords::getComma() .
                SQLWords::getBlank() .
                SQLWords::getQuotes(),
                $this->values) .
            SQLWords::getQuotes();
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
