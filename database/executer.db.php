<?php

class DatabaseExecuter
{
    public function select($query, $connection)
    {
        $encode = array();
        $result = $connection->query($query);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $encode[] = $row;
            }
        }

        $connection = null; //destroying PDO object
        return $encode;
    }
}