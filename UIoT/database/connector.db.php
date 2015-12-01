<?php

namespace UIoT\database;

use UIoT\properties\DatabaseProperties;
use Exception;
use PDO;

/**
 * Class DatabaseConnector
 */
final class DatabaseConnector
{
    var $user;
    var $pass;
    var $name;
    var $host;
    var $type;
    var $port;

    public function __construct()
    {
        self::set_user(DatabaseProperties::DB_USER());
        self::set_pass(DatabaseProperties::DB_PASS());
        self::set_name(DatabaseProperties::DB_NAME());
        self::set_host(DatabaseProperties::DB_HOST());
        self::set_type(DatabaseProperties::DB_TYPE());
        self::set_port(DatabaseProperties::DB_PORT());
    }

    public function get_name()
    {
        return $this->name;
    }

    public function set_name($name)
    {
        $this->name = (isset($name) ? $name : NULL);
    }

    public function get_host()
    {
        return $this->host;
    }

    public function set_host($host)
    {
        $this->host = (isset($host) ? $host : NULL);
    }

    public function get_port()
    {
        return $this->port;
    }

    public function set_port($port)
    {
        $this->port = (isset($port) ? $port : NULL);
    }

    public function get_PDO_object()
    {
        try {
            switch (self::get_type()):
                case 'mysql':
                    $conn = self::get_mysql_connection();
                    break;
            endswitch;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
        return $conn;
    }

    public function get_type()
    {
        return $this->type;
    }

    public function set_type($type)
    {
        $this->type = (isset($type) ? $type : NULL);
    }

    private function get_mysql_connection()
    {
        $conn = new PDO("mysql:host={$this->host};
								port={$this->port};
								dbname={$this->name}",
            self::get_user(),
            self::get_pass(),
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        return $conn;
    }

    /**
     * @return string|null
     */
    public function get_user()
    {
        return $this->user;
    }

    public function set_user($user)
    {
        $this->user = (isset($user) ? $user : NULL);
    }

    /**
     * @return string|null
     */
    public function get_pass()
    {
        return $this->pass;
    }

    public function set_pass($pass)
    {
        $this->pass = (isset($pass) ? $pass : NULL);
    }


}