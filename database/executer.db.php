<?php

class DatabaseExecuter
{
    public function execute($query, $connection)
    {
        //var_dump($query);
        //echo"<br>";
        $encode = array();
        $result = $connection->query($query);

        if(!self::is_select($query)) {
            if(!$result)
                return false;
            return true;
        }

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $encode[] = $row;
            }
        }

        $connection = null; //destroying PDO object
        return $encode;
    }

    private function is_select($query)
    {
        if(substr($query,0,6) != SQL::SELECT)
            return false;
        return true;
    }
}