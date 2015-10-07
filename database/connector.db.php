<?php

include_once ROOT_REST_DIR . "/properties/database.properties.php";

/**
 * Class DatabaseController
 */
final class DatabaseController
{
    var $user;
    var $pass;
    var $name;
    var $host;
    var $type;
    var $port;

    public function __construct()
    {
        global $database;
        self::set_user($database['user']);
        self::set_pass($database['pass']);
        self::set_name($database['name']);
        self::set_host($database['host']);
        self::set_type($database['type']);
        self::set_port($database['port']);
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

    public function get_type()
    {
        return $this->type;
    }

    public function set_type($type)
    {
        $this->type = (isset($type) ? $type : NULL);
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

    
  

  

  

   
}