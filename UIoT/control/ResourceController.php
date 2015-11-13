<?php

namespace UIoT\control;

use UIoT\database\DatabaseConnector;
use UIoT\database\DatabaseExecuter;

class ResourceController
{
    var $db_connector;
    var $db_executer;

    public function __construct()
    {
        self::create_db_executer();
        self::create_db_connector();
    }

    private function create_db_executer()
    {
        $this->db_executer = new DatabaseExecuter();
    }

    private function create_db_connector()
    {
        $this->db_connector = new DatabaseConnector();
    }

    public function execute_request($request)
    {
        var_dump($request);
        die();
    }

    private function get_connection()
    {
        return $this->db_connector->get_PDO_object();
    }

}