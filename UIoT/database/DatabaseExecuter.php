<?php

namespace UIoT\database;

use PDO;
use stdClass;
use UIoT\exceptions\EmptyOrNullRowDataValueException;
use UIoT\sql\SQL;

/**
 * Class DatabaseExecuter
 * @package UIoT\database
 */
class DatabaseExecuter
{
    /**
     * Executes a query.
     *
     * @param string $query
     * @param PDO $connection
     *
     * @return array|bool|int|object|string
     *
     * @throws EmptyOrNullRowDataValueException
     */
    public function execute($query, PDO $connection)
    {
        $finalResult = new stdClass();

        $result = $connection->query($query);

        if (!self::isSelect($query))
            return (bool)$result;

        if ($result->rowCount() > 0)
            $finalResult = $result->fetchAll(PDO::FETCH_ASSOC);

        if ($finalResult === false)
            throw new EmptyOrNullRowDataValueException;

        return $finalResult;
    }

    /**
     * Checks whether or not the query's method is 'SELECT'.
     *
     * @param string $query
     * @return bool
     */
    private function isSelect($query)
    {
        return !(substr($query, 0, 6) != SQL::SELECT);
    }
}
