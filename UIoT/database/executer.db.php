<?php

namespace UIoT\database;

use PDO;
use UIoT\sql\SQL;

class DatabaseExecuter
{
    public function execute($query, PDO $connection)
    {
        $final_result = "";
        $result = $connection->query($query);


        if (!self::is_select($query)) {
            return (bool) $result;

        }

        if ($result->rowCount() > 0)
            $final_result = $result->fetchAll(PDO::FETCH_ASSOC);

        return $final_result;
    }

    private function is_select($query)
    {
        return !(substr($query, 0, 6) != SQL::SELECT);
    }
}