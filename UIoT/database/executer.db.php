<?php

namespace UIoT\database;

use PDO;
use UIoT\sql\SQL;

class DatabaseExecuter
{
    public function execute($query, $connection)
    {
        $final_result = "";
        $result = $connection->query($query);


        if (!self::is_select($query)) {
            if (!$result)
                return false;
            return true;
        }

        if ($result->rowCount() > 0)
            $final_result = $result->fetchAll(PDO::FETCH_ASSOC);

        return $final_result;
    }

    private function is_select($query)
    {
        if (substr($query, 0, 6) != SQL::SELECT)
            return false;
        return true;
    }
}