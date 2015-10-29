<?php

class DatabaseExecuter
{
    public function execute($query, $connection)
    {
        //var_dump($query);
        //echo"<br>";
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